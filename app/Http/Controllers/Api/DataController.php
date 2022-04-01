<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function init()
    {
        return DB::table('members')->select('occupation')->distinct()->whereNotNull('occupation')->orderBy('occupation')->pluck('occupation');
        // return DB::select('select distinct(occupation) from members where occupation is not null order by occupation asc');
    }
}
