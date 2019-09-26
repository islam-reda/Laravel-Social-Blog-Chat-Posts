<?php

namespace App\Events;

use App\Events\Event;
use App\Replies as Reply;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReplyEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $reply;

    public $id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['person'];
    }
    public function broadcastAs(){
        $this->reply['person_name'] = $this->reply->user->first_name.' '.$this->reply->user->last_name;
        $this->reply['person_photo'] = $this->reply->user->imagePath;
        return 'reply';
    }
}
