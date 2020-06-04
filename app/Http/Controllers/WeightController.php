<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Weight;

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
        //viewから渡された日付時刻を取得
        $measured_date = $request->year.'-'.$request->month.'-'.$request->day;
        $measured_time = ' '.$request->hour.':'.$request->minute.':'.$request->second;
        $date_time = $measured_date.$measured_time;
        
        //viewから渡された体重を取得
        $weight_value = (double)($request->weight1.'.'.$request->weight2);

        //認証を許可したユーザーのIDを取得
        $id = auth()->user()->id;

        //取得した値をデータベースに書き込み
        $weight = new Weight;
        $weight->user_id = $id;
        $weight->weight = $weight_value;
        $weight->measured_dt = $date_time;
        $weight->save();

        return redirect('mypage');
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
        $weight = Weight::find($id);
        $measured_date = $weight->measured_dt;
        $dates = [  'year' => date('Y', strtotime($measured_date)),
                    'month' => date('m', strtotime($measured_date)),
                    'day' => date('d', strtotime($measured_date))];

        $times = [  'hour' => date('H', strtotime($measured_date)),
                    'minute' => date('i', strtotime($measured_date)),
                    'second' => date('s', strtotime($measured_date))];
        
        $weights = explode('.', $weight->weight);

        ##小数点以下が0の時に、index1の要素が空になってしまうため、明示的に０を格納する
        if (count($weights) == 1){   $weights[1] = '0'; }

        $id = $weight->id;
        
        return view('weight.edit', compact( 'dates' ,'times', 'weights', 'id' ));
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
        //weight | measured_dtを更新するために取得
        $weight_info = Weight::find($id);

        //measured_dtカラムにセットする値を生成
        $req_date = $request->year.'/'.$request->month.'/'.$request->day;
        $req_time = ' '.$request->hour.':'.$request->minute.':'.$request->second;
        $measured_dt = $req_date.$req_time;

        //weightカラムにセットする値を生成
        $weight = (double)($request->weight1.'.'.$request->weight2);

        //weightカラムの値とmeasured_dtカラムの値を更新
        $weight_info->measured_dt = $measured_dt;
        $weight_info->weight = $weight;
        $weight_info->save();

        return redirect('mypage');
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
