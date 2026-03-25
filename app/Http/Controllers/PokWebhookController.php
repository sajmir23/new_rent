<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin\BookingStatus;
use App\Models\Admin\PaymentStatus;
use App\Models\Company\Booking;
use App\Models\User;
use App\Notifications\BookingCreatedApiController;
use App\Notifications\BookingPaidApiController;
use App\Services\BookingStatusSyncService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class PokWebhookController extends Controller
{
    /**
     * Trajton Webhook-un që vjen nga POK kur një pagesë ndryshon status.
     */
    public function handle(Request $request)
    {
        // 1. Logojmë payload-in e webhook-ut për të pasur historik
        Log::info('POK Webhook Received: ', $request->all());

        try {
            // POK zakonisht dërgon ID e porosisë në webhook (p.sh., orderId ose id)
            // Duhet ta përshtatësh këtë emërtim nëse POK e dërgon ndryshe në payload
            $pokOrderId = $request->input('orderId') ?? $request->input('id');

            // Nëse nuk ka Order ID, diçka nuk shkon me formatin, por i kthejmë 200 POK-ut që të mos e nisë prapë
            if (!$pokOrderId) {
                Log::warning('POK Webhook missing Order ID.');
                return response()->json(['status' => 'ignored']);
            }

            // Gjejmë rezervimin tonë bazuar në session_id ku ne ruajtëm POK Order ID gjatë hapit store
            $booking = Booking::where('session_id', $pokOrderId)->first();

            if (!$booking) {
                Log::warning("POK Webhook: Booking not found for Order ID {$pokOrderId}");
                return response()->json(['status' => 'ignored']);
            }

            // Nëse rezervimi është konfirmuar tashmë nga metoda `success` në frontend, nuk bëjmë asgjë
            if ($booking->payment_status_id === PaymentStatus::PAID) {
                return response()->json(['status' => 'already_processed']);
            }

            // --- Server-to-Server Verification (Bulletproof Security) ---

            // Hapi A: Marrim Token-in
            $authResponse = Http::post(config('services.pok.endpoint') . '/auth/sdk/login', [
                'keyId'     => config('services.pok.key_id'),
                'keySecret' => config('services.pok.key_secret'),
            ]);

            $token = $authResponse->json('accessToken') ?? $authResponse->json('data.accessToken');

            if (empty($token)) {
                throw new Exception("Webhook Verifier: Auth failed.");
            }

            // Hapi B: Pyesim POK për statusin e vërtetë të kësaj porosie
            $merchantId = config('services.pok.merchant_id');
            $verifyUrl = config('services.pok.endpoint') . "/merchants/{$merchantId}/sdk-orders/{$pokOrderId}";

            $verifyResponse = Http::withToken($token)->acceptJson()->get($verifyUrl);

            if ($verifyResponse->successful()) {
                $statusData = $verifyResponse->json();

                $isCompleted = $statusData['data']['sdkOrder']['isCompleted'] ?? false;
                $isCaptured  = ($statusData['data']['sdkOrder']['capturedAmount'] ?? 0) > 0;

                // Nëse POK konfirmon që është paguar, konfirmojmë rezervimin!
                if ($isCompleted || $isCaptured) {

                    $booking->update([
                        'booking_status_id' => BookingStatus::CONFIRMED,
                        'payment_status_id' => PaymentStatus::PAID,
                    ]);

                    app(BookingStatusSyncService::class)->syncVehicleStatus($booking);

                    $companyAdmins = User::where('user_type', \App\Enums\UserTypesEnum::COMPANY_ADMIN)
                        ->where('company_id', $booking->company_id)
                        ->get();
                    $systemAdmins = User::where('user_type', \App\Enums\UserTypesEnum::SYSTEM_ADMIN)->get();

                    Notification::send($companyAdmins->merge($systemAdmins), new BookingCreatedApiController($booking));
                    Notification::route('mail', $booking->email)->notify(new BookingPaidApiController($booking));

                    Log::info("POK Webhook: Booking {$booking->booking_code} successfully processed in background.");

                    return response()->json(['status' => 'success']);
                }
            }

            Log::warning("POK Webhook: Order {$pokOrderId} is not paid yet according to API.");
            return response()->json(['status' => 'pending']);

        } catch (\Exception $e) {
            Log::error('POK Webhook Error: ' . $e->getMessage());
            // Gjithmonë kthe 200 OK te Webhook-u, ndryshe serveri i tyre do të vazhdojë të të bëjë "spam"
            return response()->json(['status' => 'error'], 200);
        }
    }


    /*public function handle(Request $request)
    {
        Log::info('POK Webhook Received: ', $request->all());

        try {
            $pokOrderId = $request->input('orderId') ?? $request->input('id');

            if (!$pokOrderId) {
                Log::warning('POK Webhook missing Order ID.');
                return response()->json(['status' => 'ignored']);
            }

            // 1. Marrim Token-in
            $authResponse = Http::post(config('services.pok.endpoint') . '/auth/sdk/login', [
                'keyId'     => config('services.pok.key_id'),
                'keySecret' => config('services.pok.key_secret'),
            ]);
            $token = $authResponse->json('accessToken') ?? $authResponse->json('data.accessToken');

            // 2. Verifikojmë statusin real te POK
            $merchantId = config('services.pok.merchant_id');
            $verifyResponse = Http::withToken($token)->get(config('services.pok.endpoint') . "/merchants/{$merchantId}/sdk-orders/{$pokOrderId}");

            if (!$verifyResponse->successful()) {
                return response()->json(['status' => 'error_verifying'], 200);
            }

            $statusData = $verifyResponse->json();
            $isCompleted = $statusData['data']['sdkOrder']['isCompleted'] ?? false;
            $isCaptured  = ($statusData['data']['sdkOrder']['capturedAmount'] ?? 0) > 0;

            // --- Logjika e SUKSESIT ---
            if ($isCompleted || $isCaptured) {
                $booking = Booking::where('session_id', $pokOrderId)->first();

                if ($booking && $booking->payment_status_id !== PaymentStatus::PAID) {
                    $booking->update([
                        'booking_status_id' => BookingStatus::CONFIRMED,
                        'payment_status_id' => PaymentStatus::PAID,
                    ]);

                    app(BookingStatusSyncService::class)->syncVehicleStatus($booking);

                    // Njoftimet (Identik si te success)
                    // ... (Notification logic)

                    Log::info("POK Webhook: Booking {$booking->booking_code} confirmed.");
                }
                return response()->json(['status' => 'success']);
            }

            // --- Logjika e DËSHTIMIT (FailedPayment - 1:1 me Stripe) ---
            else {
                $cacheData = cache()->get('booking_' . $pokOrderId);
                $email = $cacheData['booking_data']['email'] ?? null;
                $vehicle_id = $cacheData['booking_data']['vehicle_id'] ?? null;

                FailedPayment::updateOrCreate(
                    ['session_id' => $pokOrderId],
                    [
                        'status' => 'failed',
                        'reason' => 'Payment not completed or rejected by POK',
                        'vehicle_id' => $vehicle_id,
                        'customer_email' => $email,
                        'stripe_data' => $statusData // Ruajmë të dhënat e POK këtu
                    ]
                );

                Log::warning("POK Webhook: Payment failed for Order {$pokOrderId}");
                return response()->json(['status' => 'failed_logged']);
            }

        } catch (\Exception $e) {
            Log::error('POK Webhook Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 200);
        }
    }*/
}
