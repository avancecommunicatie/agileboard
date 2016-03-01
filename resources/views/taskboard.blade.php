@extends('master')

@section('content')
    <div class="row wrapper nav-wrapper border-bottom white-bg page-heading no-padding">
        <nav class="navbar navbar-default border-bottom">
            <div class="col-lg-9 col-md-4 col-sm-10 col-xs-12">
                <h2 style="margin-left: 1em;">{{ $projectName }}: Taskboard</h2>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-10 col-xs-12">
                <div class="row" style="margin-left: 0.8em;">
                    <div class="col-lg-offset-3 col-lg-1 col-md-4 col-sm-10 col-sm-offset-2 col-xs-12 no-padding home-btn-div">
                        <a href="{{route('home')}}" class="btn btn-sm btn-primary" style="border-radius: 15px;"><i class="fa fa-home fa-2x"></i></a>
                    </div>
                    <div class="col-lg-offset-1 col-lg-6 col-md-8 col-sm-2 col-xs-12">
                        <a href="http://in2008.nl/mantis/my_view_page.php"><h2>Ga naar Mantis</h2></a>
                    </div>
                </div>
            </div>
        </nav>
        {!! Form::open(['url' => route('taskboard.change-sprint'), 'method' => 'PUT']) !!}
        <div class="container-fluid">
            <div class="input-group">
                <div class="form-group">
                    <div class="row" id="select-sprint-section">
                        <div class="col-lg-1 col-sm-8 input-sprint">
                            {!! Form::label('sprint_id', 'Sprint #') !!}
                        </div>
                        <div class="col-lg-1 col-sm-2 no-padding">
                            @if ($sprints)
                                {!! Form::select2('sprint_id', $sprints, null, ['class' => 'select-sprint']) !!}
                            @endif
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                            <span class="input-group-btn">
                                {!! Form::hidden('project_id', $projectId) !!}
                                <button type="submit" class="btn btn-xs btn-primary" id="select-sprint-btn"> Bekijk</button>
                            </span>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>To Do</h3>
                        <p class="small"><i class="fa fa-info-circle"></i> Taken die nog opgepakt moeten worden</p>
                        @include('partials.progressbar', ['percentage' => 10, 'color' => ' background-color: #EC5B5B;'])
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
                        @include('partials.progressbar', ['percentage' => 30, 'color' => ' background-color: ##21C2CA;'])
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
                        @include('partials.progressbar', ['percentage' => 80, 'color' => ' background-color: #E081E0;'])
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
                        @include('partials.progressbar', ['percentage' => 100,  'color' => ' background-color: #4CC34C;'])
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