@extends('layouts.app')
@include('layouts.sections.header')
@include('layouts.sections.navbar')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('体重修正') }}</div>

          <div class="card-body">
              <form method="POST" action="{{ action('WeightController@update', $id) }}">
                  @csrf
                  @method('PATCH')

                  <!--日付--->
                  @component('weight.components.input_date_form',['input_state' => 'readonly',
                                                                  'year' => $dates['year'], 
                                                                  'month' => $dates['month'], 
                                                                  'day' => $dates['day']])   
                  @endcomponent

                  <!--時刻-->
                  @component('weight.components.input_time_form',['input_state' => 'readonly',
                                                                  'hour' => $times['hour'], 
                                                                  'minute' => $times['minute'], 
                                                                  'second' => $times['second']])
                  @endcomponent
                  
                  <!--体重-->
                  @component('weight.components.input_main_form',['input_state' => 'normal',
                                                                  'contents_name' => 'weight', 
                                                                  'label_name' => '体重', 
                                                                  'unit' => 'Kg',
                                                                  'contents_values' => $weights])
                  @endcomponent
                  
                  <!--登録ボタン-->
                  <input class="btn btn-primary" type="submit" value="更新">
              </form>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
