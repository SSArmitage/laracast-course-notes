<?php

namespace App\Events;

// client-side imports (for broadcasting events) - wont usually need these
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
// server-side imports (for traditional server-side events) - will usually only need these
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// an event class - should represent an action that has taken place in your system, along with any associated data (i.e. product model)
class ProductPurchased
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    // all event properties need to be public!
    public $productName;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($productName)
    {
        $this->productName = $productName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // only need if you are broadcasting to client-side
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
