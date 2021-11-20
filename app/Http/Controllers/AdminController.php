<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        return view('superadmin.admin.index',['users'=>User::where('level',1)->get()]);
    }
    public function del(Request $request,User $user){
        $user->delete();
        return redirect()->back()->with('message','User deleted Sucessfully');

    }
    public function changepass(Request $request,User $user){
        $user->password=bcrypt($request->password);
        $user->save();
        return response('ok');
    }

    public function edit(Request $request,User $user){
        if($request->getMethod()=="POST"){
            $user->email=$request->email;
            $user->password=bcrypt($request->password);
            $user->phone=$request->phone;
            $user->name=$request->name;
            $user->nagarcode=$request->mun;
            $user->save();
            return redirect()->back()->with('message','User Updated Sucessfully');
        }else{
            return view('superadmin.admin.edit',compact('user'));
        }
    }

    public function add(Request $request){
        if($request->getMethod()=="POST"){
            $user=new User();
            $user->email=$request->email;
            $user->password=bcrypt($request->email);
            $user->phone=$request->phone;
            $user->name=$request->name;
            $user->nagarcode=$request->mun;
            $user->level=1;
            $user->save();
            return redirect()->back()->with('message','User Created Sucessfully');
        }else{
            return view('superadmin.admin.add');
        }
    }
}
