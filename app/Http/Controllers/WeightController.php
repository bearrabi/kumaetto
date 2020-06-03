<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mypage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //default input date(year)
       $now_year = date('Y');
       for ($i=0;$i<2;$i++){
           $year = $now_year - 1 + $i;
           if ($year == $now_year){    $years[$year] = true;}
           else{ $years[$year] = false;  }
       }

       //default input date(month)
       $now_month = date('m');
       for ($i=1;$i<13;$i++){  
           if ($i == $now_month){  $months[$i] = true; }
           else{   $months[$i] = false;   }
       }

       //default input date(day)
       $now_day = date('d');
       for ($i=1;$i<32;$i++){  
           if ($i == $now_day){    $days[$i] = true; }
           else{   $days[$i] = false; }
       }

       //default input time(hour)
       $now_hour = date('H');
       for ($i=0;$i<25;$i++){
           if ($i == $now_hour){  $hours[$i] = true;  }
           else{   $hours[$i] = false; }
       }

       //default input time(minute)
       $now_minute = date('i');
       for ($i=0;$i<60;$i++){
           if ($i == $now_minute){  $minutes[$i] = true;  }
           else{   $minutes[$i] = false; }
       }
        
       //default input time(second)
       $now_second = date('s');
       for ($i=0;$i<60;$i++){
           if ($i == $now_second){  $seconds[$i] = true;  }
           else{   $seconds[$i] = false; }
       }
       
       return view('weight.create', compact('years','months','days','hours','minutes','seconds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('weight.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
