<?php

namespace App\Http\Controllers\Admin;

use App\AlertData;
use App\AlertHelper;
use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\MemberLevel;
use App\Models\MemberType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $alerts=Alert::where('nagarcode',$user->nagarcode)->orderBy('id','desc')->get();
        return view('admin.alert.index',compact('alerts'));
    }
    public function add()
    {
        return view('admin.alert.add');
    }

    public function show(Alert $alert){
        return view('admin.alert.view',compact('alert'));
    }
    public function resend(Alert $alert){
        AlertHelper::send($alert);
        return response()->json(['status'=>true]);
    }

    public function del(Alert $alert){
        $title=$alert->title;
        $alert->delete();
        return redirect()->back()->with('message',$title." Deletetd Sucessfully");
    }

    public function save(Request $request)
    {
        // return response()->json($request->all());
        $user = Auth::user();
        $alert = new Alert();
        $alert->title = $request->title;
        $alert->nagarcode = $user->nagarcode;
        $alert->msg = $request->message;
        $alert->is_push = $request->is_push;
        $alert->is_sms = $request->is_sms;
        $channels = [];
        $ng = 'mun_' . str_replace(':', '_', $user->nagarcode);
        $wc = count($request->ward);
        $mlc = count($request->ml);
        $mtc = count($request->mt);
        if ($request->ss == 1) {
            array_push($channels,  $ng);
        } else {

            if ($request->sel_all == 1) {
                $arr1 = [];

                if ($wc > 0 && $mlc > 0 && $mtc > 0) {
                    foreach ($request->ward as $w) {
                        foreach ($request->ml as $ml) {
                            foreach ($request->mt as $mt) {
                                array_push($channels, $ng . "_wd_" . $w . "_ml_" . $ml . "_mt_" . $mt);
                            }
                        }
                    }
                }
                if ($wc > 0 && $mlc == 0 && $mtc > 0) {
                    foreach ($request->ward as $w) {
                        foreach ($request->mt as $mt) {
                            array_push($channels, $ng . "_wd_" . $w . "_mt_" . $mt);
                        }
                    }
                }

                if ($wc > 0 && $mlc > 0 && $mtc == 0) {
                    foreach ($request->ward as $w) {
                        foreach ($request->ml as $ml) {
                            array_push($channels, $ng . "_wd_" . $w . "_ml_" . $ml);
                        }
                    }
                }

                if ($wc == 0 && $mlc > 0 && $mtc > 0) {
                    foreach ($request->ml as $ml) {
                        foreach ($request->mt as $mt) {
                            array_push($channels, $ng . "_ml_" . $ml . "_mt_" . $mt);
                        }
                    }
                }

                if ($wc == 0 && $mlc == 0 && $mtc > 0) {
                    foreach ($request->mt as $mt) {
                        array_push($channels, $ng . "_mt_" . $mt);
                    }
                }

                if ($wc == 0 && $mlc > 0 && $mtc == 0) {
                    foreach ($request->ml as $ml) {
                        array_push($channels, $ng . "_ml_" . $ml);
                    }
                }

                if ($wc > 0 && $mlc == 0 && $mtc == 0) {
                    foreach ($request->ward as $w) {
                        array_push($channels, $ng . "_wd_" . $w );
                    }
                }

                if ($wc == 0 && $mlc == 0 && $mtc == 0) {
                    array_push($channels,  $ng);
                }

            } else {

                $alert->ids = $request->ids;
            }

        }
        $alert->channels=$channels;
        $alert->data=json_encode(new AlertData($request));
        $alert->save();
        AlertHelper::send($alert);
        return response()->json(['status'=>true,'link'=>route('admin.alert.view',['alert'=>$alert->id])]);
    }
}
