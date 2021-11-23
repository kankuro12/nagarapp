<?php
namespace App;
class AlertData
{
    public $all;
    public $sel_all;
    public $ward;
    public $ml;
    public $mt;


    function  __construct($request){
        $this->all=$request->ss;
        $this->sel_all=$request->sell_all;
        $this->ward=$request->ward;
        $this->mt=$request->mt;
        $this->ml=$request->ml;
    }
}
