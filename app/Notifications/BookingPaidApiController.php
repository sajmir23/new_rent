<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingPaidApiController extends Notification implements ShouldQueue
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

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Booking Payment Received')
            ->greeting('Hello ' . $this->booking->company->name . ' ' . '!')
            ->line('A new booking payment has been received from ' . "{$this->booking->first_name} {$this->booking->last_name}.")
            ->line('Email: ' . $this->booking->email)
            ->line('Phone: ' . $this->booking->phone)
            ->line('Vehicle: ' . $this->booking->vehicle->title)
            ->line('Price: ' . $this->booking->total_price)
            ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
