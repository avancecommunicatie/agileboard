@extends('master')

@section('content')
    <div id="taskboard-header" class="row wrapper border-bottom white-bg">
        <nav class="navbar border-bottom">
            <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                <h2>{{ $projectgroup->name }}: Taskboard</h2>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{route('storyboard.index', ['projectgroup_id' => $projectgroup->id, 'sprint_id' => $sprintId])}}" class="btn btn-sm btn-success nav-btn" style="border-radius: 15px;"><i class="fa fa-comments-o fa-2x"></i></a>
                <a href="{{route('home')}}" class="btn btn-sm btn-success nav-btn" style="border-radius: 15px;"><i class="fa fa-home fa-2x"></i></a>
                <a href="//mantis.avancecommunicatie.nl/my_view_page.php" class="btn btn-sm btn-success nav-btn" style="border-radius: 15px;"><span style="font-size: 1.4em; margin-right: 10%;">Mantis</span> <i class="fa fa-angle-double-right fa-customsize" style="padding-top: 5%;"></i>
                </a>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row" id="select-sprint-section">
                <div class="col-lg-3">
                    {!! Form::open(['id' => 'change-project', 'url' => route('taskboard.change-project'), 'method' => 'POST']) !!}
                    <div class="form-group">
                        {!! Form::hidden('sprint_id', $sprintId) !!}
                        {!! Form::label('projectgroup_id', 'Agile project', ['style' => 'white-space: nowrap;']) !!}
                        @if ($projectgroups)
                            {!! Form::select('projectgroup_id', $projectgroups, $projectgroup->id, ['id' => 'select-project']) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-lg-6">
                    {!! Form::open(['id' => 'change-sprint', 'url' => route('taskboard.change-sprint'), 'method' => 'POST']) !!}
                    <div class="form-group input-sprint">
                        {!! Form::hidden('projectgroup_id', $projectgroup->id) !!}
                        {!! Form::label('sprint_id', 'Sprint #', ['style' => 'white-space: nowrap;']) !!}
                        @if ($sprints)
                            {!! Form::select('sprint_id', $sprints, $sprintId, ['id' => 'select-sprint']) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
                {{-- sprint ontkoppelen --}}
                @if(Auth::user()->id == "1")
                    <div class="col-lg-1">
                        {!! Form::open(['id' => 'clear-sprint', 'url' => route('taskboard.clear-sprint'), 'method' => 'POST']) !!}
                        <div class="form-group input-sprint">
                            {!! Form::hidden('projectgroup_id', $projectgroup->id) !!}
                            {!! Form::hidden('sprint_id', $sprintId) !!}
                            @if ($sprintId)
                                {!! Form::submit('Ontkoppel sprint', ['class' => 'btn btn-primary', 'onClick' => 'return confirm("Let op!\nWeet u zeker dat u deze sprint wilt ontkoppelen?")']) !!}
                            @endif
                        </div>
                        {!! Form::close() !!}
                    </div>
                @endif
                <div class="pull-right">
                    <div class="checkbox disable-auto-refresh" title="Pagina niet verversen na 5 minuten">
                        <label><input type="checkbox" id="disable-refresh-checkbox" value="0"><strong>Niet verversen</strong></label>
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
                        <h3>Development <span id="todo-est-time-label" class="est-time label label-default pull-right" title="Totaal aantal uur"><span class="est-time-val">{{ ($toDo ? $toDo['total_hours'] : 0) }}</span> uur</span> <span id="todo-ticket-count" class="label label-default pull-right ticket-count" title="Aantal tickets">{{ count($toDo['tickets']) }}</span></h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Taken die nog opgepakt moeten worden</p>
                        @include('taskboard.partials.progressbar', ['percentage' => 10, 'color' => ' background-color: #EC5B5B;'])
                        <ul class="sortable-list connectList agile-list" id="todo">
                            @foreach ($toDo['tickets'] as $ticket)
                                @include('partials.task_item')
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox task-section">
                    <div class="ibox-content">
                        <h3>Testen <span id="inprogress-est-time-label" class="est-time label label-default pull-right" title="Totaal aantal uur"><span class="est-time-val">{{ ($inProgress ? $inProgress['total_hours'] : 0) }}</span> uur</span> <span id="inprogress-ticket-count" class="label label-default pull-right ticket-count" title="Aantal tickets">{{ count($inProgress['tickets']) }}</span></h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Taken die op dit moment worden uitgevoerd</p>
                        @include('taskboard.partials.progressbar', ['percentage' => 30, 'color' => ' background-color: ##21C2CA;'])
                        <ul class="sortable-list connectList agile-list" id="inprogress">
                            @foreach ($inProgress['tickets'] as $ticket)
                                @include('partials.task_item')
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox task-section">
                    <div class="ibox-content">
                        <h3>Laatste controle <span id="feedback-est-time-label" class="est-time label label-default pull-right" title="Totaal aantal uur"><span class="est-time-val">{{ ($feedback ? $feedback['total_hours'] : 0) }}</span> uur</span> <span id="feedback-ticket-count" class="label label-default pull-right ticket-count" title="Aantal tickets">{{ count($feedback['tickets']) }}</span></h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Taken in afwachting van feedback</p>
                        @include('taskboard.partials.progressbar', ['percentage' => 80, 'color' => ' background-color: #E081E0;'])
                        <ul class="sortable-list connectList agile-list" id="feedback">
                            @foreach ($feedback['tickets'] as $ticket)
                                @include('partials.task_item')
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox task-section">
                    <div class="ibox-content">
                        <h3>Mededeling/Goed keuring <span id="completed-est-time-label" class="est-time label label-default pull-right" title="Totaal aantal uur"><span class="est-time-val">{{ ($completed ? $completed['total_hours'] : 0) }}</span> uur</span> <span id="completed-ticket-count" class="label label-default pull-right ticket-count" title="Aantal tickets">{{ count($completed['tickets']) }}</span></h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Voltooide taken</p>
                        @include('taskboard.partials.progressbar', ['percentage' => 100,  'color' => ' background-color: #4CC34C;'])
                        <ul class="sortable-list connectList agile-list" id="completed">
                            @foreach ($completed['tickets'] as $ticket)
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
@include('partials.navigation_script')
@include('taskboard.partials.responsive_script')
@include('taskboard.partials.taskboard_script')
@include('partials.pusher_script')
@endsection