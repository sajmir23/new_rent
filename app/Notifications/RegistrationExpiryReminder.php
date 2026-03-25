<?php

namespace App\Notifications;

use App\Models\Company\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationExpiryReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $vehicle;
    protected $daysLeft;

    protected $channels;

    /**
     * Create a new notification instance.
     */
    public function __construct(Vehicle $vehicle, int $daysLeft)
    {
        $this->vehicle = $vehicle;
        $this->daysLeft = $daysLeft;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $this->channels ?? ['mail','database'];
    }

    public function onDatabase()
    {
        $this->channels = ['database'];
        return $this;
    }

    public function onMail()
    {
        $this->channels = ['mail'];
        return $this;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Registration Expiry Reminder')
            ->greeting('Hello ' . auth()->user()->first_name . ' ' . auth()->user()->last_name . '!')
            ->line("The vehicle {$this->vehicle->title}")
            ->line("Plate: {$this->vehicle->plate}")
            ->line("Registration Expiring: {$this->vehicle->registration_expiry->format('d-m-Y')} ({$this->daysLeft} days left)")
            ->line('Thank you for using our Rental platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $expiryDate = $this->vehicle->registration_expiry ? $this->vehicle->registration_expiry->format('Y-m-d') : 'N/A';
        return [
            'message' => "The vehicle '{$this->vehicle->title}' with plate '{$this->vehicle->plate}' has its registration expiring  on {$expiryDate}."
        ];
    }
}
