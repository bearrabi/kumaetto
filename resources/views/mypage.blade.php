@extends('layouts.app')
@include('layouts.sections.header')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @component('layouts.components.slide')  @endcomponent
        </div>
    </div>
</div>
@endsection