@extends('layouts.app')
@include('layouts.sections.header')
@include('layouts.sections.navbar')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('体重記録') }}</div>

          <div class="card-body">
              <form method="POST" action="{{ route('weight.store') }}">
                  @csrf

                  <!--日付--->
                  @component('weight.components.input_date_form',['input_state' => 'normal',
                                                                  'years' => $years, 
                                                                  'months' => $months, 
                                                                  'days' => $days])   
                  @endcomponent

                  <!--時刻-->
                  @component('weight.components.input_time_form',['input_state' => 'normal',
                                                                  'hours' => $hours, 
                                                                  'minutes' => $minutes, 
                                                                  'seconds' => $seconds])
                  @endcomponent
                  
                  <!--体重-->
                  @component('weight.components.input_main_form',['input_state' => 'normal',
                                                                  'contents_name' => 'weight', 
                                                                  'label_name' => '体重', 
                                                                  'unit' => 'Kg',
                                                                  'contents_values' => ''])  <!--新規登録なので、入力項目の初期値(contents_values)は空とする-->

                  @endcomponent
                  
                  <!--登録ボタン-->
                  <input class="btn btn-info" type="submit" value="保存">
              </form>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
