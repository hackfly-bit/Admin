<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $userName;
    public $roomId;
    public $message;

    public function __construct($userName, $roomId, $message)
    {
        $this->userName = $userName;
        $this->roomId = $roomId;
        $this->message = $message;

        // Log event instantiation
        Log::info('MessageSent event instantiated', [
            'userName' => $this->userName,
            'roomId' => $this->roomId,
            'message' => $this->message,
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Log broadcasting channel
        Log::info('Broadcasting on channel: chat.' . $this->roomId);

        return [new Channel('chat.' . $this->roomId)];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        // Log broadcast payload
        Log::info('Broadcasting payload', [
            'userName' => $this->userName,
            'message' => $this->message,
        ]);

        return [
            'userName' => $this->userName,
            'message' => $this->message,
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }
}
