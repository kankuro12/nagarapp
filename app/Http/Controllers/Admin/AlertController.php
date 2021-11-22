<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberLevel;
use App\Models\MemberType;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index(){
        $channels=[];
        return view('admin.alert.index');
    }
    public function add(){
        return view('admin.alert.add');
    }
}
