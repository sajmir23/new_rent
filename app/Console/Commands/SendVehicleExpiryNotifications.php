<?php

namespace App\Console\Commands;

use App\Models\Company\Vehicle;
use App\Notifications\InsuranceExpiryReminder;
use App\Notifications\RegistrationExpiryReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendVehicleExpiryNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   protected $signature = 'app:vehicle-expiry-notification';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send database notifications for upcoming vehicle insurance and registration expiries';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $daysBeforeList = [7, 3, 1];
        $today = Carbon::today();

        foreach ($daysBeforeList as $days)
        {
            $targetDate = $today->copy()->addDays($days);

            $insuranceVehicles = Vehicle::whereDate('insurance_expiry', $targetDate)->get();

            foreach ($insuranceVehicles as $vehicle) {
                $user = $vehicle->creator;
                if (!$user) {
                    $this->warn("No creator for vehicle ID: {$vehicle->id}");
                    continue;
                }
                $user->notify((new InsuranceExpiryReminder($vehicle, $days))->onDatabase());

                event(new \App\Events\InsuranceExpiryEvent($vehicle, $days));
                sleep(2);

                $this->info("Insurance expiry: DB notified & email queued for vehicle: {$vehicle->plate}");
            }

            $registrationVehicles = Vehicle::whereDate('registration_expiry', $targetDate)->get();

            foreach ($registrationVehicles as $vehicle)
            {
                $user = $vehicle->creator;

                if (!$user) {
                    $this->warn("No creator for vehicle ID: {$vehicle->id}");
                    continue;
                }

                $user->notify((new RegistrationExpiryReminder($vehicle, $days))->onDatabase());

                event(new \App\Events\RegistrationExpiryEvent($vehicle, $days));

                sleep(5);
                $this->info("Registration expiry: DB notified & email queued for vehicle: {$vehicle->plate}");
            }
        }

        return 0;
    }





}
