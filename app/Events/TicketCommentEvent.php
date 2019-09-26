<?php

namespace App\Events;

use App\Events\Event;
use App\TicketComment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketCommentEvent extends Event
{
    use SerializesModels;

    public $comment;

    public $id;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct(TicketComment $comment)
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

        $this->comment['person_name'] = $this->comment->user_id->first_name.' '.$this->comment->user_id->last_name;
        $this->comment['person_photo'] = $this->comment->user_id->imagePath;
        return 'ticketcomment';
    }
}
