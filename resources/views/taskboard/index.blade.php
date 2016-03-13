@extends('master')

@section('content')
    <div id="taskboard-header" class="row wrapper border-bottom white-bg">
        <nav class="navbar border-bottom">
            <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                <h2>{{ $project->name }}: Taskboard</h2>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-1 col-md-3 col-sm-10 col-xs-12">
                        <a href="{{route('home')}}" id="home-btn" class="btn btn-sm btn-primary" style="border-radius: 15px;"><i class="fa fa-home fa-2x"></i></a>
                    </div>
                    <div class="col-lg-offset-1 col-lg-7 col-md-9 col-sm-2 col-xs-12">
                        <a href="http://in2008.nl/mantis/my_view_page.php"><h2 style="white-space: nowrap">Ga naar Mantis</h2></a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="form-group">
                <div class="row" id="select-sprint-section">
                    <div class="col-lg-4">
                        <div class="row">
                            {!! Form::open(['id' => 'change-project', 'url' => route('taskboard.change-project'), 'method' => 'POST']) !!}
                            <div class="col-lg-2 col-md-6 col-sm-8 col-xs-8 input-sprint">
                                {!! Form::hidden('sprint_id', $sprintId) !!}
                                {!! Form::label('project_id', 'Project #', ['style' => 'float: right; white-space: nowrap;']) !!}
                            </div>
                            <div class="col-lg-10 col-md-6 col-sm-4 col-xs-2">
                                @if ($projects)
                                    {!! Form::select('project_id', $projects, $project->id, ['id' => 'select-project']) !!}
                                @endif
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            {!! Form::open(['id' => 'change-sprint', 'url' => route('taskboard.change-sprint'), 'method' => 'POST']) !!}
                            <div class="col-lg-1 col-md-6 col-sm-9 col-xs-10 input-sprint">
                                {!! Form::hidden('project_id', $project->id) !!}
                                {!! Form::label('sprint_id', 'Sprint #', ['style' => 'float: right; white-space: nowrap;']) !!}
                            </div>
                            <div class="col-lg-11 col-md-6 col-sm-3 col-xs-2">
                                @if ($sprints)
                                    {!! Form::select('sprint_id', $sprints, $sprintId, ['id' => 'select-sprint']) !!}
                                @endif
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="taskboard-content" class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox task-section">
                    <div class="ibox-content">
                        <h3>To Do</h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Taken die nog opgepakt moeten worden</p>
                        @include('taskboard.partials.progressbar', ['percentage' => 10, 'color' => ' background-color: #EC5B5B;'])
                        <ul class="sortable-list connectList agile-list" id="todo">
                            @foreach ($toDo as $ticket)
                                @include('partials.task_item')
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox task-section">
                    <div class="ibox-content">
                        <h3>In Behandeling</h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Taken die op dit moment worden uitgevoerd</p>
                        @include('taskboard.partials.progressbar', ['percentage' => 30, 'color' => ' background-color: ##21C2CA;'])
                        <ul class="sortable-list connectList agile-list" id="inprogress">
                            @foreach ($inProgress as $ticket)
                                @include('partials.task_item')
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox task-section">
                    <div class="ibox-content">
                        <h3>Feedback</h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Taken in afwachting van feedback</p>
                        @include('taskboard.partials.progressbar', ['percentage' => 80, 'color' => ' background-color: #E081E0;'])
                        <ul class="sortable-list connectList agile-list" id="feedback">
                            @foreach ($feedback as $ticket)
                                @include('partials.task_item')
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox task-section">
                    <div class="ibox-content">
                        <h3>Afgerond</h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Voltooide taken</p>
                        @include('taskboard.partials.progressbar', ['percentage' => 100,  'color' => ' background-color: #4CC34C;'])
                        <ul class="sortable-list connectList agile-list" id="completed">
                            @foreach ($completed as $ticket)
                                @include('partials.task_item')
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom-script')
@parent
@include('taskboard.partials.responsive_script')
@include('taskboard.partials.taskboard_script')
@include('partials.pusher_script')
@endsection