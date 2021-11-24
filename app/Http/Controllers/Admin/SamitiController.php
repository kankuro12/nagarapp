<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Samiti;
use App\Models\SamitiMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SamitiController extends Controller
{
    //
    public function index(){
        $samitis=Samiti::where('nagarcode',Auth::user()->nagarcode)->orderBy('order')->get();
        return view('admin.samiti.index',compact('samitis'));
    }

    public function add(Request $request){
        $samiti=new Samiti();
        $samiti->name=$request->name;
        $samiti->order=$request->order;
        $samiti->show=$request->show??0;
        $samiti->save();
        return redirect()->back()->with('message','Samiti '.$samiti->name.' Added Sucessfully');
    }
    public function edit(Request $request,Samiti $samiti){
        $samiti->name=$request->name;
        $samiti->order=$request->order;
        $samiti->show=$request->show??0;
        $samiti->save();
        return redirect()->back()->with('message','Samiti '.$samiti->name.' Updates Sucessfully');
    }
    public function del(Request $request,Samiti $samiti){
        $name=$samiti->name;
        $samiti->delete();
        return redirect()->back()->with('message','Samiti '.$name.' Deleted Sucessfully');
    }

    public function view(Request $request,Samiti $samiti){
            $members=SamitiMember::where('samiti_id',$samiti->id)->get();
            return view('admin.samiti.member.index',compact('samiti','members'));
    }
}
