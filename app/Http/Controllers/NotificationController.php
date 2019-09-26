<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Notification;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
class NotificationController extends Controller
{
    public function index()
    {
      $notifications = Notification::orderBy('created_at','desc')->paginate(10);

      return view('posts.notification',compact('notifications'));
    }
}
