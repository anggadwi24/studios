<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    //
    public function index(){
        return view('auth.login');
    }

    public function do(Request $request){
        $validator = Validator::make($request->all(), [
       
            'email'=> 'required|email:dns',
      
            'password'=> 'required',
        ]);
        if($validator->fails()){
            $msg = $validator->errors()->all();
            Alert::error('Error',  $msg);
            return redirect('auth');
        }else{
            if(Auth::attempt(['users_email'=>$request->email,'password'=>$request->password,'users_active'=>'y'])){
                $request->session()->regenerate();
                return redirect()->intended('/');
            }else{
                Alert::error('Error','Email or Password is incorrect.');
                return redirect('auth');
            }
        }
    }
    function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
 
        return redirect('/auth');
    }
}
