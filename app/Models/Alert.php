<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;
    protected $casts = [
        'ids' => 'array',
        'channels' => 'array',
        'is_sms'=>'boolean',
        'is_push'=>'boolean'
    ];

    public function getStat(){
        $data=json_decode($this->data);
        $stat=[];
        $stat['all']=$data->all==1?'yes':'no';
        $stat['sel_all']=$data->sel_all==1?'yes':'no';
        if(count($data->ml)>0){
            $stat['ml']=implode(',',MemberLevel::whereIn('id',$data->ml)->pluck('name'));
        }
        if(count($data->mt)>0){
            $stat['mt']=implode(',',MemberType::whereIn('id',$data->mt)->pluck('name'));
        }

        $stat['ward']=implode(',',$data->ward);
        return $stat;
    }


}
