<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('体重記録') }}</div>

          <div class="card-body">
              <form method="POST" action="{{ route($route) }}">
                  @csrf

                  <!--日付--->
                  @component('weight.components.input_date_form',['years' => $years, 
                                                                  'months' => $months, 
                                                                  'days' => $days])   
                  @endcomponent

                  <!--時刻-->
                  @component('weight.components.input_time_form',['hours' => $hours, 
                                                                  'minutes' => $minutes, 
                                                                  'seconds' => $seconds])
                  @endcomponent
                  
                  
                  <!--登録ボタン-->
                  <input class="btn btn-info" type="submit" value="{{$button_value}}">
              </form>
          </div>
        </div>
    </div>
  </div>
</div>
