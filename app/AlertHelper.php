<?php

namespace App;

use App\Models\Alert;
use App\Models\News;
use App\Models\PushKey;
use App\Models\SMSMock;
use App\Models\User;
use App\SMS\Aakash;
use Google\Cloud\Storage\Notification;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as MessagingNotification;

class AlertHelper
{

    public static function sendNews(News $news)
    {
        $factory = (new Factory)->withServiceAccount(storage_path('app/firebase.json'));
        $messaging = $factory->createMessaging();
        $channel  = 'mun_' . str_replace(':', '_', $news->nagarcode);
        $message = CloudMessage::withTarget('topic', $channel)
            ->withNotification(MessagingNotification::create('Lastest News', $news->title,asset($news->image)));
        $messaging->send($message);
    }
    public static function send(Alert $alert)
    {
        $factory = (new Factory)->withServiceAccount(storage_path('app/firebase.json'));
        $messaging = $factory->createMessaging();
        $data = json_decode($alert->data);
        if ($alert->is_push) {


            if ($data->all == 1 || $data->sel_all == 1) {
                foreach ($alert->channels as $channel) {
                    $message = CloudMessage::withTarget('topic', $channel)
                        ->withNotification(MessagingNotification::create($alert->title, $alert->msg));
                    $messaging->send($message);
                }
            } else {
                $tokens = PushKey::whereIn('user_id', $alert->ids)->pluck('token');

                $message = CloudMessage::new()->withNotification(MessagingNotification::create($alert->title, $alert->msg));
                if ($tokens->count() > 450) {
                    $count = $tokens->count();
                    $skip = 0;
                    // dd($tokens,$tokens->count());

                    $temp_arr = [];
                    while ($count > 0) {

                        if ($skip == 0) {
                            array_push($temp_arr, $tokens->take(450)->all());
                        } else {
                            array_push($temp_arr, $tokens->skip($skip)->take(450)->all());
                        }
                        $count -= 450;
                        $skip += 450;
                    }
                    foreach ($temp_arr as $token_list) {
                        $messaging->sendMulticast($message, $token_list);
                    }
                } else {
                    $messaging->sendMulticast($message, $tokens->toArray());
                }
            }
        }

        if ($alert->is_sms) {
            $numbers = [];
            if ($data->all == 1) {
                $numbers = User::where('nagarcode', Auth::user()->nagarcode)->where('level', 3)->pluck('phone');
            } else if ($data->sel_id == 1) {
                $numbers = self::getNumbers($data, $alert->nagarcode);
            } else {
                $numbers = User::whereIn('ids', $alert->ids)->pluck('phone');
            }
            if (count($numbers) > 450) {
                $count = count($numbers);
                $skip = 0;
                // dd($numbers,$numbers->count());

                $temp_arr = [];
                while ($count > 0) {

                    if ($skip == 0) {
                        array_push($temp_arr, $numbers->take(450)->all());
                    } else {
                        array_push($temp_arr, $numbers->skip($skip)->take(450)->all());
                    }
                    $count -= 450;
                    $skip += 450;
                }

                foreach ($temp_arr as $number_list) {
                    Aakash::send(new SMSMock(['to' => implode(',', $number_list), 'text' => $alert->msg]));
                }
            } else {
                Aakash::send(new SMSMock(['to' => implode(',', $numbers), 'text' => $alert->msg]));
            }
        }
    }


    public static function getNumbers($data, $nagarcode)
    {

        $users_query = User::join('members', 'members.user_id', '=', 'users.id')
            ->join('member_types', 'member_types.id', '=', 'members.member_type_id')
            ->join('member_levels', 'member_levels.id', '=', 'members.member_level_id');

        if (count($data->ward) > 0) {
            $users_query = $users_query->whereIn('members.ward', $data->ward);
        }
        if (count($data->ml) > 0) {
            $users_query = $users_query->whereIn('members.member_level_id', $data->ml);
        }
        if (count($data->mt) > 0) {
            $users_query = $users_query->whereIn('members.member_type_id', $data->mt);
        }
        return $users_query->where('users.nagarcode', $nagarcode)->pluck('users.phone');
    }

    public static function stat($alert)
    {
        $push = 0;
        $sms = 0;
    }
}
