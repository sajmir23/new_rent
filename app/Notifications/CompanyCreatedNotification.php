<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $company;

    /**
     * Create a new notification instance.
     */
    public function __construct($company)
    {
        $this->company = $company;
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Company Created')
            ->line('You have new company created ' . "{$this->company->name}")
            ->line('Email: ' . $this->company->email)
            ->line('Phone: ' . $this->company->phone)
            ->line('Address: ' . $this->company->address)
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
            'message' => " New company titled '{$this->company->name}' has been created",
            'company_id' => $this->company->id,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => " New company titled '{$this->company->name}' has been created",
            'company_id' => $this->company->id,
        ]);
    }
}
