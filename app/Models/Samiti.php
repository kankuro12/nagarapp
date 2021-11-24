<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Samiti extends Model
{
    use HasFactory;
    protected $casts=[
        'show'=>'boolean'
    ];
}
