<?php

namespace App\Services;

use App\Models\Company\AdditionalService;
use App\Models\Company\Delivery;
use App\Models\Company\Insurance;
use App\Models\Company\Vehicle;
use Carbon\Carbon;

class BookingPricingService
{
    /**
     * Calculates the full booking cost, including:
     * - vehicle subtotal (from VehiclePricingService),
     * - insurance total,
     * - addons total,
     * - delivery fees,
     * - and final booking total.
     *
     * Produces a complete final price summary used for storing the booking.
     */

    public function calculate(array $data, Vehicle $vehicle): array
    {
        // Parse full timestamps (CORRECT)
        $pickup = Carbon::parse("{$data['pickup_date']} {$data['pickup_time']}");
        $dropoff = Carbon::parse("{$data['dropoff_date']} {$data['dropoff_time']}");

        if ($pickup->gte($dropoff)) {
            throw new \Exception("Dropoff must be after pickup.");
        }

        // Calculate rental days using real hours
        $totalHours = $pickup->diffInHours($dropoff);
        $days = max(1, ceil($totalHours / 24)); // Minimum 1 day

        // Calculate vehicle pricing
        $pricing = app(VehiclePricingService::class)
            ->calculate($vehicle, $pickup, $dropoff, $days);

        // Addons
        $addonsTotal = 0;
        $services = $data['additional_services'] ?? [];

        if (is_string($services)) {
            $services = json_decode($services, true);
        }

        foreach ($services as $item) {
            $service = AdditionalService::findOrFail($item['id']);
            $quantity = $item['quantity'] ?? 1;
            $addonsTotal += $service->service_price * $quantity;
        }

        // Insurance: per day + deposit
        $insuranceTotal = 0;
        $depositTotal = 0;

        if (!empty($data['insurance_id'])) {
            $insurance = Insurance::findOrFail($data['insurance_id']);
            $insuranceTotal = ($insurance->price_per_day ?? 0) * $days;

            if ($insurance->has_deposit && !empty($insurance->deposit_price)) {
                $depositTotal = $insurance->deposit_price;
            }
        }

        // Deliveries
        $deliveriesTotal = 0;

        if (!empty($data['pickup_location'])) {
            $deliveriesTotal += Delivery::findOrFail($data['pickup_location'])->price;
        }

        if (!empty($data['dropoff_location'])) {
            $deliveriesTotal += Delivery::findOrFail($data['dropoff_location'])->price;
        }

        // Final total
        $totalPrice = $pricing['total_price']
            + $addonsTotal
            + $insuranceTotal
            + $deliveriesTotal;
        // + $depositTotal

        return [
            'base_price'        => $pricing['total_price'],
            'addons_total'      => $addonsTotal,
            'insurance_total'   => $insuranceTotal,
            'deposit_total'     => $depositTotal,
            'deliveries_total'  => $deliveriesTotal,
            'total_price'       => round($totalPrice, 2),
            'total_days'        => $days,
        ];
    }
}
