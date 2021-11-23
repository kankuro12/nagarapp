<?php

namespace App\Http\Controllers;

use App\Models\PushKey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FireBaseController extends Controller
{

    public function subscribe(Request $request)
    {
        $user = Auth::user();
        $results=[];
        if($user->auth)
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
            $error=false;
            foreach ($result as $key => $value) {
                if(!is_array($value)){
                    $error=true;
                    break;
                }
            }
            if(!$error){
                $tokenHolder->subscribed=1;
            }
        }
        return response('ok');
    }
    public function test($id, Request $request)
    {
        // dd(storage_path('app/firebase.json'));
        // $factory = (new Factory)->withServiceAccount(storage_path('app/firebase.json'));
        // $messaging = $factory->createMessaging();
        $deviceToken = 'dLo9BTGxp6OX7J547Rh3Kx:APA91bEIES7qqZIngUyuiEATFSslXq4_ONK28K79_HCKOaiQCAnfCDsQlN83-JWIWMQBd5J00_Ayl5uYpvuua40C1TOrfk0MR8oA2FVqTxVFPAJJhf-phGs3soNiNK1niWd2QclWHFEa';
        // $message = CloudMessage::withTarget('token', $deviceToken)
        //     ->withNotification(Notification::create('Title', 'Body'));

        // $messaging->send($message);
        // $data=[];
        // $message = CloudMessage::withTarget('topic', '44_2')
        //     ->withNotification(Notification::create('Title', 'Body'));
        // $messaging->send($message);
        // $member = User::Find($id);
        // $m = $member->member;
        // $ng = 'mun_' . str_replace(':', '_', $member->nagarcode);
        // array_push($data,  $ng);
        // array_push($data, $ng . "_wd_" . $m->ward);
        // array_push($data, $ng . "_mt_" . $m->member_type_id);
        // array_push($data, $ng . "_ml_" . $m->member_level_id);
        // array_push($data, $ng . "_wd_" . $m->ward . "_mt_" . $m->member_type_id);
        // array_push($data, $ng . "_wd_" . $m->ward . "_ml_" . $m->member_level_id. "_mt_" . $m->member_type_id);
        // array_push($data, $ng . "_wd_" . $m->ward . "_ml_" . $m->member_level_id);
        // $result = $messaging->subscribeToTopics($data, $deviceToken);
        // dd($result);
        // $tokenHolder=PushKey::where('user_id',$id)->where('token',$request->token)->first();
        // if($tokenHolder==null){
        //     $tokenHolder=new PushKey();
        //     $tokenHolder->user_id=$id;
        //     $tokenHolder->token=$request->token;
        //     $tokenHolder->subscribed=0;
        //     // $tokenHolder->save();
        // }

        $tokenHolder = new PushKey();
        $tokenHolder->user_id = $id;
        $tokenHolder->token = $deviceToken;
        $tokenHolder->subscribed = 1;
        $tokenHolder->save();
    }
}
