<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientApiNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $company;
    protected $admin;

    /**
     * Create a new notification instance.
     */
    public function __construct($company,$admin)
    {
        $this->company = $company;
        $this->admin=$admin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to Our Rental Platform!')
            ->greeting('Hello ' . $this->admin->first_name)
            ->line('Thank you for becoming a seller with us. We are excited to have you onboard!')
            ->line('Your company ' . $this->company->name . ' has been successfully registered.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'A new company has been registered : ' .$this->company->name,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => 'A new company has been registered : ' .$this->company->name,
        ]);
    }
}
