<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// APIs

$api  = app('Dingo\Api\Routing\Router');

$api->version('v1',function ($api){

    $api->post('authenticate','App\HTTP\Controllers\UserController@authenticate');

    $api->get('users','App\HTTP\Controllers\UserController@getUsers');

    $api->get('users/{id}','App\HTTP\Controllers\UserController@getUser');

});

$api->version('v1',['middleware'=>'api.auth'],function ($api){

    $api->get('users','App\HTTP\Controllers\UserController@getUsers');

    $api->get('users/{id}','App\HTTP\Controllers\UserController@getUser');

});

// End of API


// Visitor


Route::group(['middleware'=>'visitor'],function (){

    Route::get('/login', 'UserController@login');

    Route::post('/login','UserController@postLogin');

});

// End of Visitor


Route::group(['middleware'=>'admin'],function (){

    Route::get('/','IndexController@getIndex');

    Route::get('/index.html','IndexController@getIndex');

    Route::get('/index' ,'IndexController@getIndex');

    Route::get('/widgets', function () {
        return view('layouts.widgets');
    });

    Route::get('/widgets.html', function () {
        return view('layouts.widgets');
    });

    Route::get('/charts', function () {
        return view('base.index');
    });

    Route::get('/charts.html', function () {
        return view('layouts.charts');
    });

    Route::get('/elements', function () {
        return view('layouts.elements');
    });

    Route::get('/elements.html', function () {
        return view('layouts.elements');
    });

    Route::get('/panels', function () {
        return view('layouts.panels');
    });

    Route::get('/panels.html', function () {
        return view('layouts.panels');
    });

    Route::get('/logout','UserController@logout');

    Route::get('/login.html','UserController@logout');

    /// Chat
    Route::post('chat','IndexController@postMessage');

    Route::post('request','IndexController@postFriendRequest');

    Route::post('accept-friend-request','IndexController@postAcceptFriendRequest');

    Route::get('/profile','UserController@getProfile');

    ///accept-friend-request
    ///
    // islam work
    Route::resource('/brandnews','BrandnewsController');
    Route::resource('/brands','BrandsController');
    Route::resource('/customers','CustomersController');
    Route::resource('/vouchers','VouchersController');
    Route::resource('/stores','StoresController');
    Route::resource('/admins','AdminsController');
    Route::resource('/posts','PostsController');
    Route::resource('/comments','CommentController');

    ///////
    Route::resource('/tickets','TicketController');
    Route::post('/ticket_comment','TicketCommentController@comment');

    //Route::post('/ticket_replay','TicketCommentController@replay');
//////////////////

    Route::post('/comment','CommentController@comment');

    Route::post('/vote','CommentController@vote');
    Route::post('/reply','CommentController@reply');
    Route::get('/export/customers/','CustomersController@export');
    Route::post('/import/customers/','CustomersController@importExcel');

    Route::get('/userimage/{filename}',['as' => 'user.image','uses'=>'UserController@getUserImage',]);

    Route::get('/register', 'UserController@register');

    Route::post('/register','UserController@postRegister');
    Route::get('/notifications','NotificationController@index');


    /// end of islam work

//    Route::get('/calender',function (){
//
//        return view('calender');
//    });

    Route::get('/calender','CalenderController@index');

    //load_calender_events
    Route::get('/load_calender_events','CalenderController@load');
    Route::post('/insert_calender_events','CalenderController@insert');
    Route::post('/update_calender_events','CalenderController@update');
    Route::post('/delete_calender_events','CalenderController@delete');

    Route::post('/save_calender_events_details','CalenderController@saveCalenderEventsDetails');

    //show_event_details
    Route::get('/show_event_details','CalenderController@showEventDetails');





});

    //api
    //support tickets
    Route::any('/api/tickets','\App\HTTP\Controllers\Api\SupportticketsController@tickets');
    Route::any('/api/ticket','\App\HTTP\Controllers\Api\SupportticketsController@ticket');
    Route::any('/api/addticket','\App\HTTP\Controllers\Api\SupportticketsController@addticket');
    Route::any('/api/getselects','\App\HTTP\Controllers\Api\SupportticketsController@getselects');
    Route::any('/api/addcomment','\App\HTTP\Controllers\Api\SupportticketsController@addcomment');
    // auth users
    Route::any('/api/user/register','\App\HTTP\Controllers\Api\UserController@register');
    Route::any('/api/user/login','\App\HTTP\Controllers\Api\UserController@authenticate');
    Route::any('/api/user/activate','\App\HTTP\Controllers\Api\UserController@verfyUser');
