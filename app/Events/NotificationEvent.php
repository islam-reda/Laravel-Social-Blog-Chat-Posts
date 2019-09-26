<?php

namespace App\Events;

use App\Events\Event;
use App\Notification;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
class NotificationEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $notification;

    public $id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
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
        $this->notification['person_photo'] = $this->notification->fromuser->imagePath;
        $notificationtext = '';
        if(strtolower($this->notification->message) == 'comment'){
          $notificationtext = 'New Comment on Your Post From';
        }elseif(strtolower($this->notification->message) == 'message'){
          $notificationtext = 'New Message From';
        }elseif(strtolower($this->notification->message) == 'reply'){
          $notificationtext = 'New Reply On Your Comment From';
        }
        $this->notification['name'] =  $this->notification->fromuser->first_name.' '.$this->notification->fromuser->last_name;
         // '.Carbon::parse($this->notification->created_at)->diffForHumans().'
        $this->notification['message'] =$notificationtext;
        return 'notification';
    }
}
