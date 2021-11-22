<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;
    protected $casts = [
        'numbers' => 'array',
        'channels' => 'array',
        'is_sms'=>'boolean',
        'is_push'=>'boolean'
    ];


}
