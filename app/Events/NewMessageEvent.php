<?php

namespace App\Events;

use App\Events\Event;
use App\Message;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessageEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

public $id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {

        return ['chat'];
    }

    public function broadcastAs(){

        //message
        return 'message';
    }
}
