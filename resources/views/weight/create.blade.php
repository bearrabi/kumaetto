@extends('layouts.app')
@include('layouts.sections.header')
@include('layouts.sections.navbar')
@section('content')

<!--入力フォーム-->
@component('weight.components.input_form',[ 'date_input_state' => 'normal',
                                            'time_input_state' => 'normal',
                                            'main_input_state' => 'normal',
                                            'route' => 'weight.store',
                                            'button_value' => '保存',
                                            'years' => $years, 
                                            'months' => $months, 
                                            'days' => $days,
                                            'hours' => $hours,
                                            'minutes' => $minutes,
                                            'seconds' => $seconds]
                                            )  
@endcomponent

@endsection
