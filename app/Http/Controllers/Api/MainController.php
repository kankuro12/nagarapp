<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\PushKey;
use App\Models\Samiti;
use App\Models\SamitiMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;

class MainController extends Controller
{
    public function samiti(Request $request)
    {
        $nagarcode = $request->nagarcode ?? '44:2';
        $samitis = Samiti::where('nagarcode', $nagarcode)->where('show', 1)->orderBy('order')->select('id', 'name')->get();
        $ids = $samitis->pluck('id');
        $_mem = SamitiMember::whereIn('samiti_id', $ids)->orderBy('order')->get()->groupBy('samiti_id');
        foreach ($samitis as $samiti) {
            $samiti->members = $_mem[$samiti->id];
        }

        // dd($ids);
        return response()->json($samitis);
    }

    public function news(Request $request)
    {
        $nagarcode = $request->nagarcode ?? '44:2';
        $step = $request->step ?? 0;
        if ($step == 0) {
            $news = News::take(10)->orderBy('id', 'desc')->get();
        } else {
            $news = News::skip($step * 10)->take(10)->orderBy('id', 'desc')->get();
        }
        return response()->json(['data' => $news, 'hasmore' => News::count() > (($step + 1) * 10)]);
    }

    public function user(Request $request)
    {
        $phone=$request->phone.'';
        // dd($phone);
        // dd(User::where('phone', $request->phone)->where('level', 3));
        $user = User::where('phone', $phone)->where('level', 3)->first();
        if ($user == null) {
            return response()->json(['status' => false]);
        } else {
            return response()->json(['status' => true, 'user' => $user]);
        }
    }

    public function subscribe(Request $request)
    {
        $user = User::where('phone', $request->phone)->where('level', 3)->first();
        if ($user == null) {
            return response()->json(['status' => false]);
        } else {
            $results = [];
            $factory = (new Factory)->withServiceAccount(storage_path('app/firebase.json'));
            $messaging = $factory->createMessaging();
            $tokenHolder = PushKey::where('token', $request->token)->first();
            if ($tokenHolder == null) {
                $tokenHolder = new PushKey();
                $tokenHolder->user_id = $user->id;
                $tokenHolder->token = $request->token;
                $tokenHolder->subscribed = 0;
                $tokenHolder->save();
            } else {
                if ($tokenHolder->user_id != $user->id) {
                    $tokenHolder->user_id = $user->id;
                    $tokenHolder->subscribed == 0;
                    $result = $messaging->unsubscribeFromAllTopics($request->token);
                    $tokenHolder->save();
                }
            }
            if ($tokenHolder->subscribed == 0) {
                $data=[];
                $member = $user;
                $m = $member->member;
                $ng = 'mun_' . str_replace(':', '_', $member->nagarcode);
                array_push($data,  $ng);
                array_push($data, $ng . "_wd_" . $m->ward);
                array_push($data, $ng . "_mt_" . $m->member_type_id);
                array_push($data, $ng . "_ml_" . $m->member_level_id);
                array_push($data, $ng . "_wd" . $m->ward . "_mt" . $m->member_type_id);
                array_push($data, $ng . "_wd" . $m->ward . "_ml" . $m->member_level_id);
                $result = $messaging->subscribeToTopics($data, $request->token);
                $error = false;
                foreach ($result as $key => $value) {
                    if (!is_array($value)) {
                        $error = true;
                        break;
                    }
                }
                if (!$error) {
                    $tokenHolder->subscribed = 1;
                }
            }
            return response('ok');
        }
    }

    public function member(Request $request)
    {
        $nagarcode = $request->nagarcode ?? '44:2';
        $step = $request->step ?? 0;
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
        $users_query = $users_query->where('users.nagarcode', $nagarcode);
        // dd($users_query->toSql(),$users_query->getBindings());
        if ($request->filled('usestep')) {
            if ($step == 0) {
                $users = $users_query->take(10)->orderBy('id', 'desc')->get();
            } else {
                $users = $users_query->skip($step * 10)->take(10)->orderBy('id', 'desc')->get();
            }
        } else {

            $users = $users_query->get();
        }

        return response()->json($users);
        // return view('admin.member.table', compact('users'));
    }
}
