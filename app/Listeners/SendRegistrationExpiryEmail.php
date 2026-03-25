<?php

namespace App\Listeners;

use App\Events\RegistrationExpiryEvent;
use App\Notifications\InsuranceExpiryReminder;
use App\Notifications\RegistrationExpiryReminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRegistrationExpiryEmail implements ShouldQueue
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
    public function handle(RegistrationExpiryEvent $event): void
    {
        $user = $event->vehicle->creator;
        if ($user && $user->email)
        {
            $user->notify((new RegistrationExpiryReminder($event->vehicle, $event->daysLeft))->onMail());
        }
    }
}
