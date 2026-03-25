<?php

namespace App\Services;

use App\Models\Company\Vehicle;
use App\Models\Company\Tariff;
use App\Models\Company\SeasonalPrice;
use Carbon\CarbonPeriod;

class VehiclePricingService
{
    /**
     * Calculates the effective rental pricing for a vehicle based on:
     * - base daily rate,
     * - seasonal multipliers,
     * - long-term tariff discounts,
     * - and the total rental days.
     *
     * Returns the full breakdown: total days, applied multipliers,
     * base rate, final daily rate, and vehicle subtotal.
     */

    public function calculate(Vehicle $vehicle, $pickup, $dropoff, int $days): array
    {
        $baseDailyRate = $vehicle->base_daily_rate;

        // Build period including all calendar days
        $period = CarbonPeriod::create($pickup->copy()->startOfDay(), $dropoff->copy()->startOfDay());

        // Load seasonal multipliers
        $seasonalPrices = SeasonalPrice::where('company_id', $vehicle->company_id)->get();

        $dailyRates = [];

        foreach ($period as $day) {
            $multiplier = 1.0;

            foreach ($seasonalPrices as $season) {
                if ($day->between($season->start_date, $season->end_date)) {
                    $multiplier *= $season->rate_multiplier;
                }
            }

            $dailyRates[] = $baseDailyRate * $multiplier;
        }

        // Safe fallback: if period mismatch
        if (count($dailyRates) !== $days) {
            $dailyRates = array_fill(0, $days, $baseDailyRate);
        }

        // Tariff selection
        $tariff = Tariff::where('company_id', $vehicle->company_id)
            ->where('min_days', '<=', $days)
            ->where(function ($q) use ($days) {
                $q->where('max_days', '>=', $days)->orWhereNull('max_days');
            })
            ->first();

        $tariffMultiplier = $tariff ? $tariff->rate_multiplier : 1.0;

        // Apply tariff multiplier to daily rates
        $dailyRates = array_map(fn($rate) => $rate * $tariffMultiplier, $dailyRates);

        // Final daily rate = average of all days
        $finalDailyRate = array_sum($dailyRates) / count($dailyRates);

        // Total base price
        $totalPrice = $finalDailyRate * $days;

        return [
            'base_daily_rate' => $baseDailyRate,
            'final_daily_rate' => round($finalDailyRate, 2),
            'tariff_multiplier' => $tariffMultiplier,
            'total_days' => $days,
            'total_price' => round($totalPrice, 2),
        ];
    }
}
