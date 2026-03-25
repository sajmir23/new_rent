<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Company\FailedPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{

    /**
     * Handle incoming Stripe webhook events and store failed or succeeded payment data.
     *
     * This method performs the following steps:
     * 1. Reads the raw payload and Stripe signature header from the request.
     * 2. Validates the webhook using Stripe's `constructEvent` method.
     * 3. Determines the payment status based on the event type:
     *    - `payment_intent.payment_failed` → status = 'failed', reason = failure message
     *    - `payment_intent.succeeded` → status = 'succeeded', reason = 'Payment succeeded'
     * 4. Extracts the customer email from multiple possible sources safely:
     *    - `customer_details.email`
     *    - `last_payment_error.payment_method.billing_details.email`
     *    - `receipt_email`
     *    - `metadata.customer_email`
     * 5. Retrieves optional metadata from the Stripe payment intent:
     *    - `vehicle_id`
     *    - `company_id`
     * 6. Updates or creates a `FailedPayment` record in the database with the following fields:
     *    - `session_id` (Stripe payment intent ID)
     *    - `status` ('failed' or 'succeeded')
     *    - `reason` (failure reason or success message)
     *    - `vehicle_id`
     *    - `company_id`
     *    - `customer_email`
     *    - `stripe_data` (full Stripe payment intent object as array)
     * 7. Logs the payment status using Laravel's `Log::info`.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the Stripe webhook payload.
     *
     * @return \Illuminate\Http\JsonResponse Returns a JSON response with ['received' => true] if successfully processed,
     *                                      or appropriate error responses for invalid signatures or ignored event types.
     *
     * @throws \Stripe\Exception\SignatureVerificationException If the Stripe webhook signature validation fails.
     *
     * @note
     * - Unknown or unsupported Stripe events are ignored and logged.
     * - The method ensures the `FailedPayment` table reflects the latest payment attempt for a given session.
     * - Stripe metadata (`vehicle_id`, `company_id`, `customer_email`) is used to associate the payment with local entities.
     */


    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try
        {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        }
        catch (\Exception $e)
        {
            Log::error('Stripe Webhook Signature Error: ' . $e->getMessage());

            return response()->json(['error' => 'Webhook signature verification failed'], 400);
        }
        $paymentIntent = $event->data->object;

        switch ($event->type)
        {
            case 'payment_intent.payment_failed':
                $status = 'failed';
                $reason=$paymentIntent->last_payment_error->message?? 'Unknown failure';
                break;
            case 'payment_intent.succeeded':
                $status='succeeded';
                $reason='Payment succeeded';
                break;
                default:
                    Log::info('Stripe Webhook Signature Error: ' . $event->type);
                    return response()->json(['status' => 'Ignored'], 400);
        }

            $email = $checkoutSession->customer_details->email ??
                $paymentIntent->last_payment_error->payment_method->billing_details->email ??
                $paymentIntent->receipt_email ??
                $paymentIntent->metadata->customer_email ??
                null;

           $vehicle_id=$paymentIntent->metadata->vehicle_id ?? null;
           $company_id=$paymentIntent->metadata->company_id ?? null;

            FailedPayment::updateOrCreate(
                [
                    'session_id' => $paymentIntent->id
                ],

               [
                   'status' => $status,
                   'reason' =>$reason,
                   'vehicle_id' => $vehicle_id,
                   'company_id' => $company_id,
                   'customer_email' => $email,
                   'stripe_data' => $paymentIntent->toArray()
               ]);

            Log::info('Failed payment: ' . $paymentIntent->id. 'status: ' . $status);

        return response()->json(['received' => true]);
    }




}
