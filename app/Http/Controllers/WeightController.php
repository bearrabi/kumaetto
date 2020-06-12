<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Weight;
use \Yasumi\yasumi;
use Carbon\CarbonImmutable;
use Carbon\Carbon;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get data from weights table beatween firstday and lastday of month
        $now = CarbonImmutable::now();
        $firstday   =   $firstday = $now->firstOfMonth();
        $lastday    =   $now->LastOfMonth();
        $weights    =   Weight::where('user_id', auth()->user()->id)
                                ->whereBetween('measured_dt',[$firstday, $lastday])
                                ->orderby('measured_dt');
        
        //create array include table's title(h3 contents) & table's header(th contents) & table's data(td contents)
        $data_of_table_view = [ 
            'user_id'           =>  auth()->user()->id,
            'path'              =>  'weight.components.table',
            'h3_value'          =>  $now->format('Y/m').'の体重',
            'tr_values'         =>  ['Date','Weight','Operation'],
            'td_values'         =>  $weights->paginate(10)
        ];
        
        //set data of calender view
        $data_of_calender_view = [
            'path'      =>  'weight.components.calender',
            'h2_value'  =>  $now->format( 'Y年 m月' ),
            'tr_values' =>  [   [ 'class' =>  'h_sunday'    ,   'name'  =>  '日' ], 
                                [ 'class' =>  'h_weekday'   ,   'name'  =>  '月' ],
                                [ 'class' =>  'h_weekday'   ,   'name'  =>  '火' ],
                                [ 'class' =>  'h_weekday'   ,   'name'  =>  '水' ],
                                [ 'class' =>  'h_weekday'   ,   'name'  =>  '木' ],
                                [ 'class' =>  'h_weekday'   ,   'name'  =>  '金' ],
                                [ 'class' =>  'h_saturday'  ,   'name'  =>  '土' ]  ],
            'td_values' =>  $this->GetCurrentPageInfoOfCalender( $now )
        ];
        //dd($data_of_calender_view['td_values']);
        //create info of chart
        $data_of_current_month  =   $this->GetCurrentMonthsWeight( auth()->user()->id );
        
        //add path of chart view
        $datas_of_chart[ 'path' ]   =   'weight.components.chart';
        $datas_of_chart[ 'title' ]  =   $now->format( 'Y年 m月' ).'の体重推移';   
        $datas_of_chart[ 'header' ] =   [ '日付', '体重' ];
        $datas_of_chart[ 'values' ] =   $this->CretateGraphDataOfViewAtTargetMonth( $data_of_current_month );
        
        return view( 'mypage', compact( 'data_of_table_view', 'data_of_calender_view', 'datas_of_chart' ) );
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
        $date_time  =   $request->year. '-'.
                        $request->month.'-'.
                        $request->day.
                        ' '.
                        $request->hour.  ':'.
                        $request->minute.':'.
                        $request->second;
        
        //viewから渡された体重を取得
        $weight_value = (double)($request->weight1.'.'.$request->weight2);

        //認証を許可したユーザーのIDを取得
        $user_id = auth()->user()->id;

        //取得した値をデータベースに書き込み
        $weight                 =   new Weight;
        $weight->user_id        =   $user_id;
        $weight->weight         =   $weight_value;
        $weight->measured_dt    =   $date_time;
        $weight->save();

        return redirect('weight');
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
        $dates = [  'year'  =>  date('Y', strtotime($measured_date)),
                    'month' =>  date('m', strtotime($measured_date)),
                    'day'   =>  date('d', strtotime($measured_date))];

        $times = [  'hour'      =>  date('H', strtotime($measured_date)),
                    'minute'    =>  date('i', strtotime($measured_date)),
                    'second'    =>  date('s', strtotime($measured_date))];
        
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
        $measured_dt =  $request->year.'/'.
                        $request->month.'/'.
                        $request->day.
                        ' '.
                        $request->hour.':'.
                        $request->minute.':'.
                        $request->second;

        //weightカラムにセットする値を生成
        $weight = (double)($request->weight1.'.'.$request->weight2);

        //weightカラムの値とmeasured_dtカラムの値を更新
        $weight_info->measured_dt   =   $measured_dt;
        $weight_info->weight        =   $weight;
        $weight_info->save();

        return redirect('weight');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $weight = Weight::find($id);
        $weight->delete();
        
        return redirect('weight');
    }

    private function GetCurrentPageInfoOfCalender($m_now){

        //get Japanease holidays for coloring calender ... example: saturday's color is rgb(30,144,255) and holiday's color is pink etc 
        $holidays   =   Yasumi::create('Japan', $m_now->year, 'ja_JP');

        //set sunday to week start, and sudarday to week end
        CarbonImmutable::setWeekStartsAt(CarbonImmutable::SUNDAY);
        CarbonImmutable::setWeekEndsAt(CarbonImmutable::SATURDAY);

        //get week start day and week end day
        $first_day_of_first_week    =   $m_now->firstOfMonth()->startOfWeek();
        $last_day_of_last_week      =   $m_now->lastOfMonth()->endOfWeek();

        //set current page's info
        $current_page_days =   [];
        $day_of_calender    =   new Carbon( $first_day_of_first_week );

        $day_index = 0;
        while( TRUE ){

            //'sunday' or 'saturday' or 'weekday' or 'holiday' of 'other_month' for set date color of calender
            $type   =   $this->GetDayType( $day_of_calender, $holidays, $m_now );

            //array per week
            $week_days[]    =   [ 'day'    =>   $day_of_calender->day, 'type'    =>  $type ];

            //set weeks_array by saturday
            if ( $day_index  ==  6 ){   
                    $current_page_days[]    =   $week_days;  
                    $week_days              =   [];
                    $day_index              =   -1;
            }

            //break while by last of current calender page
            if ( $day_of_calender->isSameday( $last_day_of_last_week ) ){   break;  }

            //search next day
            $day_of_calender->addDay();
            $day_index++;
        }

        return $current_page_days;
    }

   //sunday or saturday or weekday or holiday
   private function GetDayType($m_day, $m_holidays_arr, $m_today ){
        
        if ( !$m_day->isCurrentMonth()        ){    return "other_month";   }
        if ( $m_day->isSameday( $m_today    ) ){    return 'today';         }
        if ( $m_day->isSunday()               ){    return "sunday";        }
        if ( $m_day->isSaturday()             ){    return "saturday";      }
        
        foreach( $m_holidays_arr as $holiday ){
            if ( $m_day->isSameday( $holiday ) ){   return "holiday";       }
        }

        //not match all type
        return "weekday";

    }

    //table's title(h3 contents) & table's header(th contents) & table's data(td contents)
    private function GetCurrentMonthsWeight($id){

        //get current month weight
        $now = CarbonImmutable::now();
        $firstday = $now->firstOfMonth();
        $lastday = $now->LastOfMonth();
        
        //get user's weight info of current month
        $weights = Weight::where('user_id',$id)
                            ->whereBetween('measured_dt',[$firstday, $lastday])
                            ->orderby('measured_dt')
                            ->get(['id', 'weight', 'measured_dt']);
        
        return $weights;
    }

    //create view's graph data
    private function CretateGraphDataOfViewAtTargetMonth( $m_datas_curr_month ){
        
        $send_to_view_json = array();

        //set weight to array of chart view
        foreach($m_datas_curr_month as $row){

            //fetch measured_dt per day from db row
            $data_per_day[ 'month_day' ]    =   date( 'n/j', strtotime( $row->measured_dt ) );;

            //fetch weight per day from db row
            $data_per_day[ 'weight' ]    =   $row->weight;

            //set array the row's data to send_to_json  
            $send_to_view_json[]    =   $data_per_day; 
        }
        return $send_to_view_json;
    }

}
