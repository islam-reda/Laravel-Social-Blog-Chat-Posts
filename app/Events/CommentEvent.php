<?php

namespace App\Events;

use App\Events\Event;
use App\Comments;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $comment;

    public $id;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct(Comments $comment)
    {
        $this->comment = $comment;
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
        $this->comment['person_name'] = $this->comment->user->first_name.' '.$this->comment->user->last_name;
        $this->comment['person_photo'] = $this->comment->user->imagePath;
        return 'comment';
    }
}
