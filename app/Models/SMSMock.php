<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSMock extends Model
{
    protected $fillable = ['to','text'];
    use HasFactory;

    public function getData($token){
        return [
            'auth_token'=>$token,
            'to'=>$this->to,
            'text'=>$this->text,
        ];
    }
}
