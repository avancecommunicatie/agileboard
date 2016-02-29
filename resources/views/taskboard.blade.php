@extends('master')

@section('content')
    <div class="row wrapper nav-wrapper border-bottom white-bg page-heading">
        <nav class="navbar navbar-default border-bottom">
            <div class="col-lg-1 col-md-4 col-sm-10 col-xs-12 pull-left" style="margin-top: 15px; margin-left:10px;">
                <a href="{{route('home')}}" class="btn btn-sm btn-primary">Terug</a>
            </div>
            <div class="col-lg-7 col-md-4 col-sm-10 col-xs-12 no-padding">
                <h2>{{ $projectName }}: Taskboard</h2>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-10 col-xs-12 pull-right">
                <a href="http://in2008.nl/mantis/my_view_page.php"><h2>Ga naar Mantis</h2></a>
            </div>
        </nav>
    </div>
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>To Do</h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Taak toewijzen aan teamlid en toevoegen aan To Do</p>
                        {!! Form::open(['url' => route('taskboard.change-sprint'), 'method' => 'PUT']) !!}
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="input-group">
                                    {!! Form::label('sprint_id', 'Sprint #') !!}
                                    {!! Form::select2('sprint_id', $sprints) !!}
                                    {!! Form::hidden('project_id', $projectId) !!}
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 no-padding">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary" id="add-ticket-btn"> Bekijk</button>
                                </span>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div class="hr-line-dashed"></div>
                        <p class="small"><i class="fa fa-info-circle"></i> Taken die nog opgepakt moeten worden</p>
                        <ul class="sortable-list connectList agile-list" id="todo">
                            @foreach ($toDo as $ticket)
                                @include('partials.task-item')
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
                                @include('partials.task-item')
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
                                @include('partials.task-item')
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
                                @include('partials.task-item')
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
            var ticket_description = $('.ticket-description');
            var task_item = $('.ticket-summary');
            var token = '{{ csrf_token() }}';

            ticket_description.hide();

            task_item.on('click', function() {
                $(this).siblings('.ticket-description').toggle('slide', { direction: "left"}, 500);
            });

            $('#todo').droppable({drop: Drop});
            $('#inprogress').droppable({drop: Drop});
            $('#feedback').droppable({drop: Drop});
            $('#completed').droppable({drop: Drop});

            $('.ticket-assign-to').on('change', function() {
                var ticketId = $(this).parents('.task-item').attr('id');
                var handlerId = $(this).val();

                $.ajax({
                    method: 'PUT'
                    , url: '{{ route('taskboard.change-handler') }}'
                    , data: {_token: token, ticketId: ticketId, handlerId: handlerId}
                });
            });

            function Drop(event, ui) {
                var draggableId = ui.draggable.attr("id");
                var droppableId = $(this).attr("id");
                var handlerId   = ui.helper.find('option').val();

                $.ajax({
                        method: 'PUT'
                        , url: '{{ route('taskboard.update-status') }}'
                        , data: {_token: token, dragId: draggableId, dropId: droppableId, handlerId: handlerId}
                    });
            }
        });
    </script>
@endsection