@extends('layouts.app')
@include('layouts.sections.header')
@include('layouts.sections.navbar')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        @component($data_of_table_view['path'], ['weight_info'  =>  $data_of_table_view ])
        @endcomponent

            <!--ログインボタン、登録ボタン-->
            <div class="row justify-content-md-center">
                <div id="login_btn" class="home_buttons col-lg-3 col-md-3 col-sm-3"> 
                    <a class="btn btn-primary" href="{{ route('weight.create') }}">新規登録</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection