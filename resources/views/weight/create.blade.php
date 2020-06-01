@extends('layouts.app')
@include('layouts.sections.header')
@include('layouts.sections.navbar')
@section('content')

<!--入力フォーム-->
@component('weight.components.input_form')  @endcomponent

@endsection
