@extends('master')

@section('content')
    <div class="row wrapper nav-wrapper border-bottom white-bg page-heading no-padding">
        <nav class="navbar navbar-default border-bottom">
            <div class="col-lg-offset-1 col-md-offset-1 col-xs-offset-1 col-lg-6 col-md-4 col-sm-5 col-xs-10 no-padding">
                <h2>{{ $projectName }}: Taskboard</h2>
            </div>
            <div class="col-sm-offset-1 col-xs-offset-1 col-lg-2 col-md-4 col-sm-5 col-xs-10 pull-right">
                <a href="{{ route('issuetracker.index') }}"><h2>Issuetracker</h2></a>
            </div>
        </nav>
    </div>
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>To Do</h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Taken die nog opgepakt moeten worden</p>
                        <div class="input-group">
                            {!! Form::select2('tasks', []) !!}
                            <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Toevoegen</button>
                            </span>
                        </div>
                        <ul class="sortable-list connectList agile-list" id="todo">
                            @foreach ($toDo as $ticket)
                                <li class="task-item {{ ($ticket->priority < 20 ? 'success' : '') }} {{ ($ticket->priority > 19 && $ticket->priority < 40 ? 'warning-element' : '') }} {{ ($ticket->priority > 40 ? 'danger-element' : '') }}" id="{{ $ticket->id }}">
                                    {{ $ticket->summary }}
                                    <div class="agile-detail">
                                        <span class="pull-right btn btn-xs btn-white">{{ $ticket->user == null ? 'ToDo' : $ticket->user->username}}</span>
                                        <div class="no-padding col-sm-3 pull-left">
                                            <i class="fa fa-clock-o"></i> {{ date('d-m-Y', $ticket->date_submitted) }}
                                        </div>
                                        <i class="fa fa-comment-o"></i> 12
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>In Behandeling</h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Taken die op dit moment worden uitgevoerd</p>
                        <ul class="sortable-list connectList agile-list" id="inprogress">
                            @foreach ($inProgress as $ticket)
                                <li class="task-item {{ ($ticket->priority < 20 ? 'success' : '') }} {{ ($ticket->priority > 19 && $ticket->priority < 40 ? 'warning-element' : '') }} {{ ($ticket->priority > 40 ? 'danger-element' : '') }}" id="{{ $ticket->id }}">
                                    {{ $ticket->summary }}
                                    <div class="agile-detail">
                                        <span class="pull-right btn btn-xs btn-white">{{ $ticket->user == null ? 'ToDo' : $ticket->user->username}}</span>
                                        <i class="fa fa-clock-o"></i> {{ date('d-m-Y', $ticket->date_submitted) }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Feedback</h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Taken in afwachting van feedback</p>
                        <ul class="sortable-list connectList agile-list" id="feedback">
                            @foreach ($feedback as $ticket)
                                <li class="task-item {{ ($ticket->priority < 20 ? 'success' : '') }} {{ ($ticket->priority > 19 && $ticket->priority < 40 ? 'warning-element' : '') }} {{ ($ticket->priority > 40 ? 'danger-element' : '') }}" id="{{ $ticket->id }}">
                                    {{ $ticket->summary }}
                                    <div class="agile-detail">

                                        <span class="pull-right btn btn-xs btn-white">{{ $ticket->user == null ? 'ToDo' : $ticket->user->username}}</span>
                                        <i class="fa fa-clock-o"></i> {{ date('d-m-Y', $ticket->date_submitted) }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Afgerond</h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Voltooide taken</p>
                        <ul class="sortable-list connectList agile-list" id="completed">
                            @foreach ($completed as $ticket)
                                <li class="task-item {{ ($ticket->priority < 20 ? 'success' : '') }} {{ ($ticket->priority > 19 && $ticket->priority < 40 ? 'warning-element' : '') }} {{ ($ticket->priority > 40 ? 'danger-element' : '') }}" id="{{ $ticket->id }}">
                                    {{ $ticket->summary }}
                                    <div class="agile-detail">

                                        <span class="pull-right btn btn-xs btn-white">{{ $ticket->user == null ? 'ToDo' : $ticket->user->username}}</span>
                                        <i class="fa fa-clock-o"></i> {{ date('d-m-Y', $ticket->date_submitted) }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom-includes')
    @parent
    <script type="text/javascript">
        $(document).ready(function() {
            var token = '{{ csrf_token() }}';

            $('#todo').droppable({drop: Drop});
            $('#inprogress').droppable({drop: Drop});
            $('#feedback').droppable({drop: Drop});
            $('#completed').droppable({drop: Drop});

            function Drop(event, ui) {
                var draggableId = ui.draggable.attr("id");
                var droppableId = $(this).attr("id");

                $.ajax({
                        method: 'PUT'
                        , url: '{{ route('taskboard.update-status') }}'
                        , data: {_token: token, dragId: draggableId, dropId: droppableId}
                    });
            }
        });
    </script>
@endsection