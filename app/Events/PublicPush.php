<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublicPush implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;
    public $data;
    public $title;
    public $description;

    /**
     * Create a new event instance.
     *
     * @param $channel
     * @param $data
     * @param $title
     * @param null $description
     */
    public function __construct($channel, $data, $title = null, $description = null)
    {
        $this->channel = $channel;
        $this->data = $data;
        $this->title = $title;
        $this->description = $description;
    }

    public function broadcastWith()
    {
        return [
            'data' => $this->data,
            'title' => $this->title,
            'message' => $this->description
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel($this->channel);
    }
}
