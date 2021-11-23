<?php
namespace App;

use App\Models\Alert;
use App\Models\PushKey;
use Google\Cloud\Storage\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as MessagingNotification;

class AlertHelper{

    public static function send(Alert $alert){
        $factory = (new Factory)->withServiceAccount(storage_path('app/firebase.json'));
        $messaging = $factory->createMessaging();
         $data= json_decode($alert->data);
         if($alert->is_push){

             if($data->all==1 || $data->sel_all==1){
                 foreach ($alert->channels as $channel) {
                     $message = CloudMessage::withTarget('topic',$channel)
                         ->withNotification(MessagingNotification::create($alert->title, $alert->msg));
                         $messaging->send($message);
                 }
             }else{
                $tokens=PushKey::whereIn('user_id',$alert->ids)->pluck('token');

                if($tokens->count>450){
                    $count=$tokens->count;
                    dd($tokens,$tokens->count());
                    $i=0;


                }else{

                }


             }
         }
    }


}
