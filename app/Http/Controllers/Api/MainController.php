<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Samiti;
use App\Models\SamitiMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function samiti(Request $request){
        $nagarcode=$request->nagarcode??'44:2';
        $samitis=Samiti::where('nagarcode',$nagarcode)->where('show',1)->orderBy('order')->select('id','name')->get();
        $ids=$samitis->pluck('id');
        $_mem=SamitiMember::whereIn('samiti_id',$ids)->orderBy('order')->get()->groupBy('samiti_id');
        foreach ($samitis as $samiti) {
            $samiti->members=$_mem[$samiti->id];
        }

        // dd($ids);
        return response()->json($samitis);
    }

    public function news(Request $request){
        $nagarcode=$request->nagarcode??'44:2';
        $step=$request->step??0;
        if($step==0){
            $news=News::take(10)->orderBy('id','desc')->get();
        }else{
            $news=News::skip($step*10)->take(10)->orderBy('id','desc')->get();
        }
        return response()->json(['data'=>$news,'hasmore'=>News::count()>(($step+1)*10)]);

    }


    public function member(Request $request)
    {
        $nagarcode=$request->nagarcode??'44:2';
        $step=$request->step??0;
        // dd($request->all());
        $users_query = User::join('members', 'members.user_id', '=', 'users.id')
            ->join('member_types', 'member_types.id', '=', 'members.member_type_id')
            ->join('member_levels', 'member_levels.id', '=', 'members.member_level_id')
            ->select(
                DB::raw(
                    'users.id,
                users.name,
                users.phone,
                users.email,
                users.nagarcode,
                member_types.name as mt,
                member_levels.name as ml,
                members.ward,
                members.address,
                members.occupation'
                )
            );
        if ($request->filled('ward')) {
            $users_query = $users_query->whereIn('members.ward', $request->ward);
        }
        if ($request->filled('ml')) {
            $users_query = $users_query->whereIn('members.member_level_id', $request->ml);
        }
        if ($request->filled('mt')) {
            $users_query = $users_query->whereIn('members.member_type_id', $request->mt);
        }
        if ($request->filled('occupation')) {
            $occupations = explode(',', $request->occupation);
            if (count($occupations) > 0) {
                $users_query = $users_query->where(function ($query) use ($occupations) {
                    foreach ($occupations as $key => $occupation) {
                        $query->orWhere('members.occupation', 'like', '%' . $occupation . '%');
                    }
                });
            }
        }
        $users_query=$users_query->where('users.nagarcode', $nagarcode);
        // dd($users_query->toSql(),$users_query->getBindings());
        if($request->filled('usestep')){
            if($step==0){
                $users=$users_query->take(10)->orderBy('id','desc')->get();
            }else{
                $users=$users_query->skip($step*10)->take(10)->orderBy('id','desc')->get();
            }
        }else{

            $users = $users_query->get();
        }

        return response()->json($users);
        // return view('admin.member.table', compact('users'));
    }

}
