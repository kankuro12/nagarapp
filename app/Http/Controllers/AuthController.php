<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        if($request->getMethod()=="POST"){
            $data=$request->validate([
                'email'=>'email|required',
                'password'=>'required'
            ]);
            // dd($request->all());
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$request->filled('me')))
            {
                return redirect()->route('dashboard')->with('message',Auth::user()->name. ' Logged In Sucessfuly');
            }else{
                return redirect()->back()->with('error','Login Failed Please Retry');
            }

        }else{
            return view('login');
        }
    }
}
