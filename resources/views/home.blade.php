@extends('layouts.app')

@section('content')
    <!-- Main content -->

    <p class="card-text">
        {{ __('You are logged in!') }}
    </p>
    <div style="width: 35vw;height:35vw">
        <canvas id="myChart"></canvas>
    </div>


    <!-- /.content -->
@endsection
