<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberLevel;
use App\Models\MemberType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class MemberController extends Controller
{
    public function index()
    {


        return view('admin.member.index');
    }

    public function load(Request $request)
    {
        // dd($request->all());
        $auser = Auth::user();
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
        // dd($users_query->toSql(),$users_query->getBindings());
        $users = $users_query->where('users.nagarcode', $auser->nagarcode)->get();
        // return response()->json($users);
        return view('admin.member.table', compact('users'));
    }
    public function add(Request  $request)
    {
        $auser = Auth::user();
        if ($request->getMethod() == "POST") {
            // dd($request->all());
            $user = new User();
            $user->email = $request->email;
            $user->password = bcrypt($request->phone);
            $user->phone = $request->phone;
            $user->name = $request->name;
            $user->nagarcode = $auser->nagarcode;
            $user->level = 3;
            $user->save();

            $member = new Member();
            $member->ward = $request->ward;
            $member->user_id = $user->id;
            $member->member_type_id = $request->member_type_id;
            $member->member_level_id = $request->member_level_id;
            $member->bg = $request->bg;
            $member->fc = $request->fc;
            $member->occupation = $request->occupation;
            $member->address = $request->address;
            if ($request->hasFile('image')) {
                $member->image = $request->image->store('member/' . Carbon::now()->format('Y/m/d'));
            }
            $member->save();
            return response('ok');
        } else {
            return view('admin.member.add', [
                'mls' => MemberLevel::all(),
                'mts' => MemberType::all(),
                'user' => $auser
            ]);
        }
    }

    public function edit(Request  $request, User $member)
    {
        if ($request->getMethod() == "POST") {
            // dd($request->all());
            
            $member->email = $request->email;
            $member->phone = $request->phone;
            $member->name = $request->name;
            $member->save();

            $_member = Member::where('user_id', $member->id)->first();
            $_member->ward = $request->ward;
            $_member->member_type_id = $request->member_type_id;
            $_member->member_level_id = $request->member_level_id;
            $_member->bg = $request->bg;
            $_member->fc = $request->fc;
            $_member->occupation = $request->occupation;
            $_member->address = $request->address;
            if ($request->hasFile('image')) {
                $_member->image = $request->image->store('member/' . Carbon::now()->format('Y/m/d'));
            }
            $_member->save();
            return redirect()->back()->with('message','Member Updated Sucessfully');
        } else {

            return view('admin.member.edit', [
                'member' => $member,
                'mls' => MemberLevel::all(),
                'mts' => MemberType::all(),
            ]);
        }
    }

    public function del(Request $request)
    {
        Member::where('user_id', $request->id)->delete();
        User::where('id', $request->id)->delete();
        return response('ok');
    }

    private function make()
    {
    }
}
