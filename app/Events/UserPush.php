<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPush implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $data;
    public $title;
    public $description;

    /**
     * Create a new event instance.
     *
     * @param $user
     * @param $data
     * @param null $title
     * @param null $description
     */
    public function __construct($user, $data, $title = null, $description = null)
    {
        $this->user = $user;
        $this->data = $data;
        $this->title = $title;
        $this->description = $description;
    }

    public function broadcastWith()
    {
        return [
            'data' => $this->data,
            'title' => $this->title,
            'description' => $this->description
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.'.$this->user->id);
    }
}
