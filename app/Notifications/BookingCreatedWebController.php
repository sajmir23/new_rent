<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreatedWebController extends Notification implements ShouldQueue
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
        return ['database'];
    }

  /*  public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Booking Created')
            ->greeting('Hello ' . auth()->user()->first_name . ' ' . auth()->user()->last_name . '!')
            ->line('You have a new booking from ' . "{$this->booking->first_name} {$this->booking->last_name}")
            ->line('Pickup Time: ' . "{$this->booking->pickup_time}")
            ->line('Pickup Date: ' . \Carbon\Carbon::parse($this->booking->pickup_date)->format('d-m-Y'))
            ->line('Pickup Location: ' . $this->booking->pickup_location)
            ->line('Dropoff Date: ' .  \Carbon\Carbon::parse($this->booking->dropoff_date)->format('d-m-Y'))
            ->action('View Booking', url('/company/bookings/show/' . $this->booking->id))
            ->line('Thank you for using our Rental platform!');
    }*/

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "New booking created by {$this->booking->first_name} {$this->booking->last_name},  model: {$this->booking->vehicle->title} from " . \Carbon\Carbon::parse($this->booking->pickup_date)->format('d-m-Y') .
                " to " . \Carbon\Carbon::parse($this->booking->dropoff_date)->format('d-m-Y') ,
            'booking_id' => $this->booking->id,

        ];
    }

    /*public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->booking->id,
            'customer_name' => $this->booking->first_name . ' ' . $this->booking->last_name,
            'created_at' => $this->booking->created_at->toDateTimeString(),
        ]);
    }*/

}
