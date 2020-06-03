<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('体重記録') }}</div>

          <div class="card-body">
              <form method="POST" action="{{ route($route) }}">
                  @csrf

                  <!--日付--->
                  @component('weight.components.input_date_form',['input_state' => $date_input_state,
                                                                  'years' => $years, 
                                                                  'months' => $months, 
                                                                  'days' => $days])   
                  @endcomponent

                  <!--時刻-->
                  @component('weight.components.input_time_form',['input_state' => $time_input_state,
                                                                  'hours' => $hours, 
                                                                  'minutes' => $minutes, 
                                                                  'seconds' => $seconds])
                  @endcomponent
                  
                  <!--体重-->
                  @component('weight.components.input_main_form',['input_state' => $main_input_state,
                                                                  'contents_name' => 'weight', 
                                                                  'label_name' => '体重', 
                                                                  'unit' => 'Kg'])
                  @endcomponent
                  
                  <!--登録ボタン-->
                  <input class="btn btn-info" type="submit" value="{{$button_value}}">
              </form>
          </div>
        </div>
    </div>
  </div>
</div>
