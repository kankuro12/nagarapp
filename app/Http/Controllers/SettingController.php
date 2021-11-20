<?php

namespace App\Http\Controllers;

use App\Models\MemberLevel;
use App\Models\MemberType;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        return view('superadmin.setting.index',[
            'mls'=>MemberLevel::all(),
            'mts'=>MemberType::all(),
        ]);
    }

    public function mt_add(Request $request){
        $mt=new MemberType();
        $mt->name=$request->name;
        $mt->save();
        return redirect()->back()->with('message','Member Type Added Sucessfully');
    }
    public function ml_add(Request $request){
        $mt=new MemberLevel();
        $mt->name=$request->name;
        $mt->save();
        return redirect()->back()->with('message','Member Level Added Sucessfully');
    }

    public function mt_edit(Request $request,MemberType $mt){
        $mt->name=$request->name;
        $mt->save();
        return redirect()->back()->with('message','Member Type "'.$mt->name.'" Updated Sucessfully');
    }

    public function ml_edit(Request $request,MemberLevel $ml){
        $ml->name=$request->name;
        $ml->save();
        return redirect()->back()->with('message','Member Level "'.$ml->name.'" Updated Sucessfully');
    }

    public function mt_del(Request $request,MemberType $mt){
        $tempname=$mt->name;
        $mt->delete();
        return redirect()->back()->with('message','Member Type "'.$tempname.'" Deleted Sucessfully');
    }

    public function ml_del(Request $request,MemberLevel $ml){
        $tempname=$ml->name;
        $ml->delete();
        return redirect()->back()->with('message','Member Level "'.$tempname.'" Deleted Sucessfully');
    }
}
