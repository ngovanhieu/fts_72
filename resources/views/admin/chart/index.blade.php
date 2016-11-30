@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            <div id="poll_div"></div>
            {!! $chart->render('AreaChart', 'Exams', 'poll_div') !!}
            <hr>
            <div id="poll_div_subject">
                {!! $chart->render('BarChart', 'Subject', 'poll_div_subject') !!}
            </div>
        </div>
    </div>
@endsection
