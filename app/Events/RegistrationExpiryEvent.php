<?php

namespace App\Events;

use App\Models\Company\Vehicle;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegistrationExpiryEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $vehicle;
    public $daysLeft;

    /**
     * Create a new event instance.
     */
    public function __construct(Vehicle $vehicle, int $daysLeft)
    {
        $this->vehicle = $vehicle;
        $this->daysLeft = $daysLeft;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
