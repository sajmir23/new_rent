<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusChangedPickUp extends Notification implements ShouldQueue
{
    use Queueable;
    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pickup Status')
            ->greeting('Hello ' . auth()->user()->first_name . ' ' . auth()->user()->last_name . '!')
            ->line('Booking ' . "{$this->booking->booking_code}" . 'is active')
            ->line('Vehicle: ' . "{$this->booking->vehicle->title}" . 'is rented')
            ->line('Thank you for using our Rental platform!');
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message'=>"Booking {$this->booking->booking_code} is active and vehicle {$this->booking->vehicle->title} is rented.",
            'booking_id'=>$this->booking->id,
            'vehicle_id'=>$this->booking->vehicle_id,
        ];
    }
}
