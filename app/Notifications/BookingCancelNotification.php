<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelNotification extends Notification implements ShouldQueue
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
            ->subject('Booking Cancelled')
            ->greeting('Hello ' . $this->booking->company->name . ' ' . '!')
            ->line('You have a booking cancelled from ' . "{$this->booking->first_name} {$this->booking->last_name}")
            ->line('Pickup Date: ' . $this->booking->pickup_date)
            ->line('Pickup Location: ' . $this->booking->pickup_location)
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

            'message' => "Booking {$this->booking->booking_code} from {$this->booking->first_name} {$this->booking->last_name}
             has been cancelled",

            'booking_id' => $this->booking->id,
        ];
    }
}
