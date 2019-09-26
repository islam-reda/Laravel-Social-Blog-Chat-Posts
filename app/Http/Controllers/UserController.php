<?php

namespace App\Http\Controllers;

use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

use App\Http\Requests;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class UserController extends Controller
{

    public function register(){

        return view('user.register');

    }

    public function postRegister(Request $request){

        try{

            $this->validate(request(),[

                'email' =>'required|email',
                'password' =>'required|confirmed'
            ]);

            $user = Sentinel::registerAndActivate($request->all());

            //$user = Sentinel::register($request->all());  // register

            $activation = Activation::create($user);  // crate activation

            $role = Sentinel::findRoleBySlug('admin');  // retrieve manager role
            $role->users()->attach($user);   // add manager role to user.

            //$this->sendEmail($user,$activation->code);

            return redirect('/register');


        }catch (QueryException $e){


            dd($e);
            return redirect()->back()->with(['error'=>"Duplicate Email"]);


        }



        //dd($request->all());
    }


    public function login(){

        return view('user.login');


    }



    public function postLogin(Request $request){
      //  Post::create($request->all());
      //$user = Sentinel::findById(17);
        // $user->permissions = [
//            'user.create' => true,
//            'user.delete' => false,
//        ];
//
//        $user->save();



//        $role = Sentinel::findRoleById(1);
//
//        $role->permissions = [
//            'user.update' => true,
//            'user.view' => true,
//        ];
//
//        $role->save();
//
//        \Log::info($request);
//
//        return;

        try{

            //die();
            //dd($request->all());
            //return $request->all();

            $rememberMe = false;

            if(isset($rememberMe)){
                $rememberMe =true;
            }

            if(Sentinel::authenticate($request->all(),$rememberMe)){


                //Sentinel::authenticate($request->all());
                $slug = Sentinel::getUser()->roles()->first()->slug;
                //if(Sentinel::check()){
                if($slug == 'admin') {
                    return redirect('/');
                    //return response()->json(['redirect' =>'/earnings']);
                }

//                elseif ($slug == 'manager'){
//                    return redirect('/tasks');
//                    //return response()->json(['redirect' =>'/tasks']);
//
//                }

            }else{

                // return redirect('/login')->withErrors(
                //['errors'=>'Please check your credentials and try again.']
                //);

                return redirect()->back()->with(['error'=>'Wrong credentials.']);
                //return response()->json(['error'=>'Wrong credentials.'],500);

            }


            //return Sentinel::check()->email;
            //return Sentinel::check();

            return redirect('/login');

        }
        catch (ThrottlingException $e){

            $delay = $e->getDelay();

            return redirect()->back()->with(['error'=>"You are banned for $delay seconds."]);
            //return response()->json(['error'=>"You are banned for $delay seconds."],500);

        }
        catch (NotActivatedException $e2){

            //return response()->json(['error'=>"You account is not activated!"],500);

            return redirect()->back()->with(['error'=>"You account is not activated!"]);

        }


    }



    public function getUserImage($filename){

        $file =  Storage::disk('local')->get($filename);

        return new Response($file,200);
    }


    public function logout(Request $request){


        //die();
        Sentinel::logout();

        return redirect('/login');

    }


    //////////API////////////////
    ///

    public function authenticate(Request $request){

        //return view('user.login');

        $credentials = $request->only('email','password');

        try{
            if (! $token = \Tymon\JWTAuth\Facades\JWTAuth::attempt($credentials) ){

                return response()->json(['error'=>'User credentials are not correct!'],401);

            }

        }catch (JWTException $ex){

            return response()->json(['error'=>'Something Went wrong!'],500);

        }

        return response()->json(compact('token'))->setStatusCode(200);

    }

    public function getUsers(){

        return User::all();
    }

    public function getUser($id){

        return User::find($id);
    }



}
