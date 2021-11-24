<?php

namespace App\Http\Controllers\Admin;

use App\AlertHelper;
use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsControoller extends Controller
{
    public function index(){
        $user=Auth::user();
        $news=News::where('nagarcode',$user->nagarcode)->select('title','updated_at','id')->get();
        return view('admin.news.index',compact('news'));
    }

    public function add(Request $request){
        if($request->getMethod()=="POST"){
            $news=new News();
            $news->title=$request->title;
            $news->content=$request->content;
            $news->user_id=Auth::user()->id;
            $news->nagarcode=Auth::user()->nagarcode;
            if($request->hasFile('image')){
                $news->image=$request->image->store('news/' . Carbon::now()->format('Y/m/d'));
            }
            $news->save();
            AlertHelper::sendNews($news);
            return redirect()->route('admin.news.edit',['news'=>$news->id]);
        }else{
            return view('admin.news.add');
        }



    }

    public function edit(Request $request,News $news){
        if($request->getMethod()=="POST"){
            $news->title=$request->title;
            $news->content=$request->content;

            if($request->hasFile('image')){
                $news->image=$request->image->store('news/' . Carbon::now()->format('Y/m/d'));
            }
            $news->save();
            return redirect()->back()->with('message','News Updated Sucessfully');
        }else{
            return view('admin.news.edit',compact('news'));
        }



    }

    public function del(Request $request,News $news){
        $news->delete();
        return redirect()->back()->with('message','News Deleted Sucessfully');

    }
}
