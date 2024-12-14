<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $sender;
    public $objectId;
    public function __construct($sender, $objectId)
    {
        $this->sender = $sender;
        $this->objectId = $objectId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn(): PrivateChannel
    {
//        return new Channel('be-dormitory-channel2');
        Log::info('privateNotification.' . $this->objectId);
        return new PrivateChannel('privateNotification.' . $this->objectId);
    }

    /**
     * Broadcast event user login
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        Log::info('Broadcasting as notificationPrivate');
        return 'notificationPrivateHit';
    }

    public function broadcastWith()
    {
        Log::info('Broadcasting with data: sender=' . $this->sender . ', objectId=' . $this->objectId);
        return ['sender' => $this->sender, 'objectId' => $this->objectId];
    }
}
