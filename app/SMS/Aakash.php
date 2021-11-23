<?php

namespace App\SMS;

use App\Models\SMSMock;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class Aakash
{
    const url="https://aakashsms.com/admin/public/sms/v3/send";
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public static  function send(SMSMock $sms)
    {

        switch (env('smschannel','mock')) {
            case 'aakash':
                $response = Http::post(self::url,$sms->getData(env('aakash','')));
                break;
            default:
                $sms->save();
                break;
        }

        // try {
            //code...

        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        // Send notification to the $notifiable instance...
    }
}
