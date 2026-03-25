<?php

namespace App\Listeners;

use App\Events\InsuranceExpiryEvent;
use App\Notifications\InsuranceExpiryReminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendInsuranceExpiryEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InsuranceExpiryEvent $event): void
    {
        $user = $event->vehicle->creator;
        if ($user && $user->email)
        {
            $user->notify((new InsuranceExpiryReminder($event->vehicle, $event->daysLeft))->onMail());
        }
    }
}
