<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Requests;

class UserController extends Controller
{

   public function postSignUp(Request $request)
   {

   	$this->validate($request, [
   		'email' => 'unique:users|email|required',
   		'first_name' => 'required|max:120|string',
   		'password' => 'required|min:4',
   	]);

   	$email = $request->email;
   	$first_name = $request->first_name;
   	$password = bcrypt($request->password);

   	$user = new User();
   	$user->email = $email;
   	$user->first_name = $first_name;
   	$user->password = $password;

   	$user->save();

   	Auth::login($user);

   	return redirect('dashboard');

   }

   public function postSignIn(Request $request)
   {
   	$this->validate($request, [
   		'email' => 'required',
   		'password' => 'required',
   	]);

   		if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
   			return redirect('dashboard');
   		}
   		else{
   			return redirect('');
   		}
   }


    public function logout(Request $request)
    {
      Auth::logout();
      return redirect()->route('home');
    }


    public function getAccount(){

      $user = Auth::user();

      return view('user.account', compact('user'));

    }

    public function updateAccount(Request $request){
      $this->validate($request, [ 
         'first_name' => 'required|max:120'
      ]);

      $user = Auth::user();
      $user->first_name = $request->first_name;
      $user->save(); 

      $file = $request->file('upload');
      $filename = $request->first_name. '-' .$user->id.'.jpg';

      if($file){
         Storage::disk('local')->put($filename, File::get($file));
         return redirect()->route('account')->withMessage('Your image was uploaded!');
      }

      else{
         return redirect()->route('account')->withMessage('The image was not uploaded, sorry!');
      }

    }

    public function getUserImage($filename){
      $file = Storage::disk('local')->get($filename);
      return new Response($file, 200);  
    }
}
