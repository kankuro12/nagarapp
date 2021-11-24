<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Samiti;
use App\Models\SamitiMember;
use Illuminate\Http\Request;

class SamitiMemberController extends Controller
{
    public function add($samiti_id,Request $request){
        if($request->getMethod()=="POST"){
            $member=new SamitiMember();
            $member->name=$request->name;
            $member->phone=$request->phone;
            $member->address=$request->adress;
            $member->email=$request->email;
            $member->desc=$request->desc;
            $member->designation=$request->designation;
            $member->order=$request->order;
            $member->cols=$request->cols;
            $member->samiti_id=$samiti_id;
            if($request->hasFile('image')){
                $member->image=$request->image->store('samiti');
            }
            $member->save();
            return redirect()->route('admin.samiti.view',['samiti'=>$samiti_id])->with('message','Member '.$member->name.' Added Sucessfully');
        }else{
            $samiti=Samiti::where('id',$samiti_id)->first();
            return view('admin.samiti.member.add',compact('samiti'));
        }
    }

    public function edit(SamitiMember $member,Request $request){
        if($request->getMethod()=="POST"){
            $member->name=$request->name;
            $member->phone=$request->phone;
            $member->address=$request->address;
            $member->email=$request->email;
            $member->desc=$request->desc;
            $member->designation=$request->designation;
            $member->order=$request->order;
            $member->cols=$request->cols;
            if($request->hasFile('image')){
                $member->image=$request->image->store('samiti');
            }
            $member->save();
            return redirect()->route('admin.samiti.view',['samiti'=>$member->samiti_id])->with('message','Member '.$member->name.' Updated Sucessfully');
        }else{
            $samiti=Samiti::where('id',$member->samiti_id)->first();
            return view('admin.samiti.member.edit',compact('samiti','member'));
        }
    }

    public function del(SamitiMember $member,Request $request){
        $sid=$member->samiti_id;
        $name=$member->name;
        $member->delete();
        return redirect()->route('admin.samiti.view',['samiti'=>$sid])->with('message','Member '.$name.' Deleted Sucessfully');

    }
}
