<h2>{{ $calender_info[ 'h2_value' ] }}</h2>
<table class="calender" border="1">
  
  <!--ヘッダー--->
    <tr>
      @foreach( $calender_info[ 'tr_values' ] as $day_header )
        <th class="day_name {{ $day_header[ 'class' ] }}">{{ $day_header[ 'name' ] }}</th>
      @endforeach
    </tr>

  <!--日付--->
  @foreach( $calender_info[ 'td_values' ] as $week)
    <tr>  <!--$day = 0：日,　1：月,　2：火,　3：水,　4：木,　5：金,　6：土-->
    @foreach($week as $day)
      <td>
        <div class="{{ $day[ 'type' ] }}">{{ $day[ 'day' ] }}</div>
      </td>
    @endforeach
    </tr>
  @endforeach
</table>
<style>
  .calender{ width: 100%;}
  .calender tr th,.calender tr td{  text-align: center; }
  .calender tr th{  font-size: 16px; font-weight: bold; }
  .calender tr td{  height: 90px; }
  .calender tr td:hover{  background-color: rgba( 127, 255, 212, 0.5 );  }

  /*曜日に合わせて色をセット*/
  .h_sunday{      color: rgb( 230, 0  , 0   );       }
  .h_saturday{    color: rgb( 30 , 144, 255 );       }
  .sunday{        color: rgb( 230, 0  , 0   );       }
  .saturday{      color: rgb( 30 , 144, 255 );       }
  .weekday{       color: rgb( 15 , 15 , 15  );       }
  .other_month{   color: rgba( 169, 169, 169, 0.5 ); }
  .today{         background-color: rgba( 255, 255, 0  , 0.5 ); }
  .day_name,.number{ font-family:'メイリオ', 'Meiryo', sans-serif;   }
</style>