@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!


                        </br>
                        <div style="width:100%;">
                            <center><h2>Node 1</h2></center>

                            {!! $all_chart->render() !!}
                        </div>
                        </br>
                        <div style="width:100%;">
                            <center><h2>Node 2</h2></center>
                            {!! $all_chart2->render() !!}
                        </div>
                        </br>
                        <div style="width:100%;">
                            <center><h2>Node 3</h2></center>

                            {!! $all_chart3->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Graphs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="/vendor/chart.js/Chart.js"></script>
