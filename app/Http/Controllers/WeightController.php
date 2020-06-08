<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Weight;
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

        //create array include table's title(h3 contents) & table's header(th contents) & table's data(td contents)
        $user_id    = auth()->user()->id;
        $path       = 'weight.components.table';
        $h3_value   = CarbonImmutable::now()->format('Y/m').'の体重';
        $tr_values  = ['Date','Weight','Operation'];
        $td_values  = $this->GetTableViewDatas(/*db datas of weights table at current month= */$this->GetCurrentMonthsWeight($user_id));

        //set data of table view
        $data_of_table_view = [ 
                'user_id'           =>  $user_id,
                'path'              =>  $path,
                'h3_value'          =>  $h3_value,
                'tr_values'         =>  $tr_values,
                'td_values'         =>  $td_values
        ];
        //dd($data_of_table_view);

        




        return view('mypage',compact('data_of_table_view'));
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

    //create array for adjust table td format
    private function GetTableViewDatas($m_db_weight_datas){

        //convert from Eloquent to array
        foreach($m_db_weight_datas as $datas){
            $arr_weight_db_datas[] = [  $datas->id, 
                                        $datas->measured_dt, 
                                        $datas->weight      ];
        }

        //create table row's data
        $row_datas = [];
        foreach($arr_weight_db_datas as $i => $row){

            //get id for setting delete action's parameter
            $columns_index = 0;
            $id = $row[$columns_index];

            //set measured_dt's cell
            $columns_index++; 
            $measured_dt_cell           =   $this->InitializeNonTagCellsInfo();
            $measured_dt_cell['value']  =   $row[$columns_index];
            $label_name                 =   'col'.( $columns_index - 1 );
            $cells_data[$label_name]    =   $measured_dt_cell;

            //set weight's cell
            $columns_index++;
            $weight_cell                =   $this->InitializeNonTagCellsInfo();
            $weight_cell['value']       =   $row[$columns_index];
            $weight_cell['unit']        =   'Kg';
            $label_name                 =   'col'.( $columns_index - 1 );
            $cells_data[$label_name]    =   $weight_cell;

            //set action's cell
            $columns_index++;
            $action_cell['edit']            =   $this->InitializeAnchorButtonCellsInfo();
            $action_cell['edit']['action']  =   'WeightController@edit';
            $action_cell['edit']['param']   =   $id;
            $action_cell['edit']['value']   =   '編集';

            $action_cell['delete']          =   $this->InitializeSubmitButtonCellsInfo();
            $action_cell['delete']['action']=   'WeightController@destroy';
            $action_cell['delete']['param'] =   $id;
            $action_cell['delete']['value'] =   '削除';

            $label_name                 =   'col'.( $columns_index - 1 );
            $cells_data[$label_name]    =   $action_cell;
            
            //set all column's data to array
            $label_row_index                    =   'row'.$i;
            $row_datas[$label_row_index]      =   $cells_data;

            $cells_data = [];
        }

        return $row_datas;
    }

    //initilize cells array of non tag
    private function InitializeNonTagCellsInfo(){

        return [    'tag'   =>  '',
                    'class' =>  '',
                    'value' =>  '',     
                    'unit'  =>  ''];
    }

    //initialize cells array of anchor tag
    private function InitializeAnchorButtonCellsInfo(){
        
        return [    'tag'       =>  'a', 
                    'class'     =>  'btn btn-primary',
                    'action'    =>  '',
                    'param'     =>  '',
                    'value'     =>  ''                      ];
    }

    //initialize cells array of anchor tag
    private function InitializeSubmitButtonCellsInfo(){
        
        return [    'tag'       =>  'input',
                    'type'      =>  'submit',
                    'class'     =>  'btn btn-danger', 
                    'action'    =>  '',
                    'param'     =>  '',
                    'onClick'   =>  'delete_alert(event); return false;',
                    'value'     =>  '削除'                                       ];
    }
}
