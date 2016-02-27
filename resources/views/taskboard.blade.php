@extends('master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-offset-1 col-lg-3">
            <h2>Taskboard: Naam van project</h2>
        </div>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-offset-1 col-lg-2">
            <a href="{{ route('issuetracker.index') }}"><h2>Issuetracker</h2></a>
        </div>
    </div>
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>To-do</h3>
                        <p class="small"><i class="fa fa-hand-o-up"></i> Taken die nog opgepakt moeten worden</p>

                        <div class="input-group">
                            <input type="text" placeholder="Add new task. " class="input input-sm form-control">
                            <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add task</button>
                            </span>
                        </div>

                        <ul class="sortable-list connectList agile-list" id="todo">
                            @foreach ($toDo as $ticket)
                                <li class="task-item {{ ($ticket->priority < 20 ? 'success' : '') }} {{ ($ticket->priority > 19 && $ticket->priority < 40 ? 'warning-element' : '') }} {{ ($ticket->priority > 40 ? 'danger-element' : '') }}" id="task[{{ $ticket->id }}]">
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
                        <h3>In Progress</h3>
                        <p class="small"><i class="fa fa-hand-o-up"></i> Taken die op dit moment worden uitgevoerd</p>
                        <ul class="sortable-list connectList agile-list" id="inprogress">
                            @foreach ($inProgress as $ticket)
                                <li class="task-item {{ ($ticket->priority < 20 ? 'success' : '') }} {{ ($ticket->priority > 19 && $ticket->priority < 40 ? 'warning-element' : '') }} {{ ($ticket->priority > 40 ? 'danger-element' : '') }}" id="task[{{ $ticket->id }}]">
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
                        <p class="small"><i class="fa fa-hand-o-up"></i> Taken waar feedback op moet worden gegeven</p>
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
                        <h3>Completed</h3>
                        <p class="small"><i class="fa fa-hand-o-up"></i> Voltooide taken</p>
                        <ul class="sortable-list connectList agile-list" id="completed">
                            @foreach ($completed as $ticket)
                                <li class="task-item {{ ($ticket->priority < 20 ? 'success' : '') }} {{ ($ticket->priority > 19 && $ticket->priority < 40 ? 'warning-element' : '') }} {{ ($ticket->priority > 40 ? 'danger-element' : '') }}" id="[{{ $ticket->id }}]">
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
                console.log(draggableId);
                var droppableId = $(this).attr("id");
                console.log(droppableId);

                $.ajax({
                        method: 'PUT'
                        , url: '{{ route('taskboard.update-status', 0) }}'
                        , data: {_token: token, dragId: draggableId, dropId: droppableId}
                    })
                    .done(function (response) {
                        var json = JSON.parse(response);

                        if (json.success) {

                        }
                        else {

                        }
                    });
            }
        });
    </script>
@endsection