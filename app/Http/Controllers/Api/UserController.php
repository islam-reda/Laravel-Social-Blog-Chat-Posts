<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Ticket;
use App\TicketType;
use App\TicketStatus;
use App\TicketArea;
use App\User;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Mail;
class UserController extends \App\Http\Controllers\Controller
{
    public function authenticate(Request $request){

        //return view('user.login');

        $credentials = $request->only('email','password');
        $user = Sentinel::findByCredentials($credentials);
        $userObj = $user;
        if($user){
              $user = Sentinel::validateCredentials($user, $credentials);
              if($user){
                if(!$userObj->active){
                  $activation_code = rand(10000,99999);
                  $userObj->activation_code = $activation_code;
                  $userObj->save();
                  // send email or sms
                  $this->sendEmail($userObj,$activation_code);
                  return array(
                    'success' => true,
                    'status' => $userObj->active,
                    'user_id' => $userObj->id,
                  );
                }else{
                  return array(
                    'success' => true,
                    'user' => $userObj,
                    'user_id' => $userObj->id,
                    'status' => $userObj->active,
                  );
                }
              }else{
                return array(
                  'success' => false,
                  'message' => 'Sorry Not Found User in out system',

                );
              }
          }else{
            return array(
              'success' => false,
              'message' => 'Sorry Not Found User in out system',

            );
          }

    }

    public function verfyUser(Request $request)
    {
      if(!$request->activation_code || !$request->user_id){
        return array(
          'success' => false,
          'message' => 'Some data required',
        );
      }
        $user = Sentinel::findById($request->user_id);
        if($user->activation_code == $request->activation_code){
            $activation = Activation::create($user);  // crate activation
            Activation::complete($user, $activation->code);
            $user->active = 1;
            $user->save();
            return array(
              'success' => true,
              'user' => $user,
              'user_id' => $user->id,
            );
        }else{
          $activation_code = rand(10000,99999);
          $user->activation_code = $activation_code;
          $user->save();
          // send email or sms
          $this->sendEmail($user,$activation_code);

          return array(
            'success' => false,
            'message' => 'wrong Activation Code Please check your mail to active account',
          );

        }
        $request['activation_code'] = rand(10000,99999);
        $user = Sentinel::register($request);
        $activation = Activation::create($user);  // crate activation
        $role = Sentinel::findRoleBySlug('admin');  // retrieve manager role
        $role->users()->attach($user);   // add manager role to user.
        $added = array(
          'success' => true,
          'user' => $user,
        );
        return $added;
       return array(
         'success' => false,
       );

    }

     public function register(Request $request)
     {
       $phone = $request->phone;
       if(!$request->phone || !$request->email || !$request->password || !$request->first_name || !$request->last_name){
         return array(
           'success' => false,
           'message' => 'data is dosen`t added',
         );
       }
       try{
           if($request->imagePath){
             $image = base64_decode($request->imagePath);
             $encr = rand(1, 100000000).$request->first_name.$request->email;
             $image_name= $encr.'userphoto.png';
             $path = public_path() . DIRECTORY_SEPARATOR."images" .DIRECTORY_SEPARATOR. $image_name;
             file_put_contents($path, $image);
           }
           $request = $request->all();
           $request['activation_code'] = (string)rand(10000,99999);
           $request['active'] = 0;
           $user = Sentinel::register($request);
           $user->activation_code =  $request['activation_code'];
           $user->phone =  $phone;
           $user->save();
           // $activation = Activation::create($user);  // crate activation
           $role = Sentinel::findRoleBySlug('admin');  // retrieve manager role
           $role->users()->attach($user);   // add manager role to user.
           // send email or sms
           $this->sendEmail($user,$request['activation_code']);
           $returnarray = array(
             'success' => true,
             'user' => $user,
             'message' => 'Please Check Email BOX TO ACTIVATE ACCOUNT',
           );
           return $returnarray;
        }catch(Exception $e){
           return array(
             'success' => false,
             'message' => 'There is an error occur',
           );
         }
     }
     private function sendEmail($user,$code){
        Mail::send(
            'emails.activation',
            ['user'=>$user, 'code'=>$code],
            function ($massage) use ($user){

                $massage->to($user->email);

                $massage->subject("Hello $user->first_name,Please Activate your account.");

            });
    }
}
