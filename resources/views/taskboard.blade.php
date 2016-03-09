@extends('master')

@section('content')
    <div id="taskboard-header" class="row wrapper border-bottom white-bg">
        <nav class="navbar border-bottom">
            <div class="col-lg-9 col-md-4 col-sm-10 col-xs-12">
                <h2 style="margin-left: 1%;">{{ $projectName }}: Taskboard</h2>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-10 col-xs-12">
                <div class="row clearfix">
                    <div class="col-lg-offset-2 col-lg-1 col-md-3 col-sm-10 col-sm-offset-2 col-xs-12">
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
                    {!! Form::open(['url' => route('taskboard.change-sprint'), 'method' => 'POST']) !!}
                    <div class="col-lg-4 col-md-3 col-sm-8 col-xs-8 input-sprint">
                        {!! Form::label('sprint_id', 'Sprint #', ['style' => 'white-space: nowrap;']) !!}
                    </div>
                    <div class="col-lg-1 col-md-3 col-sm-2 col-xs-2">
                        @if ($sprints)
                            {!! Form::select('sprint_id', $sprints, $sprintId, ['class' => 'select-sprint', 'style' => 'min-width: 120%;']) !!}
                        @endif
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-2 col-xs-2">
                        <span class="form-group-btn">
                            {!! Form::hidden('project_id', $projectId) !!}
                            <button type="submit" class="btn btn-xs btn-primary" id="select-sprint-btn"> Bekijk</button>
                        </span>
                    </div>
                    {!! Form::close() !!}
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
                        @include('partials.progressbar', ['percentage' => 10, 'color' => ' background-color: #EC5B5B;'])
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
                        @include('partials.progressbar', ['percentage' => 30, 'color' => ' background-color: ##21C2CA;'])
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
                        @include('partials.progressbar', ['percentage' => 80, 'color' => ' background-color: #E081E0;'])
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
                        @include('partials.progressbar', ['percentage' => 100,  'color' => ' background-color: #4CC34C;'])
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
@include('partials.responsive_script')
<script type="text/javascript">
    var user = "{{ str_random(8).date('dHis') }}";
    var project_id = '{{ $projectId }}';
    var sprint_id = '{{ $sprintId }}';
    var env = '{{ env('APP_ENV') }}';

    $(function() {
        var description_btn = $('.description-btn');
        var token = '{{ csrf_token() }}';

        $("#todo, #inprogress, #feedback, #completed").sortable({
            connectWith: ".connectList",
            handle: '.handle',
            scroll: false,
            receive: function(event, ui) {
                var todo        = $("#todo").sortable( "toArray" );
                var inprogress  = $( "#inprogress" ).sortable( "toArray" );
                var feedback    = $('#feedback').sortable("toArray");
                var completed   = $( "#completed" ).sortable( "toArray" );
                var draggableId = ui.item.attr("id");
                var droppableId = $(this).attr("id");
                $('.output').html("ToDo: " + window.JSON.stringify(todo) + "<br/>" + "In Progress: " + window.JSON.stringify(inprogress) + "Feedback: " + window.JSON.stringify(feedback) + "<br/>" + "Completed: " + window.JSON.stringify(completed));

                $.ajax({
                        method: 'POST',
                        url: '{{ route('taskboard.update-status') }}',
                        data: {
                            _token: token,
                            dragId: draggableId,
                            dropId: droppableId,
                            user: user,
                            project_id: project_id,
                            sprint_id: sprint_id,
                            env: env
                        }
                    }).done(function(response) {
                        if(response.success){
//                           toastr.success('De status van dit ticket is gewijzigd', 'Status gewijzigd!');
                        }else{
                            toastr.error('Er ging iets mis', 'Fout');
                        }
                    });
            }
        });

        description_btn.on('click', function() {
            $(this).toggleClass('fa-angle-double-down fa-angle-double-up');
            $(this).siblings('.handle').children('.ticket-description').toggle('slide', { direction: "left"}, 500);
        });

        $('.ticket-assign-to').on('change', function() {
            var ticketId = $(this).parents('.task-item').attr('id');
            var handlerId = $(this).val();

            $.ajax({
                method: 'POST'
                , url: '{{ route('taskboard.change-handler') }}'
                , data: {
                    _token: token,
                    ticketId: ticketId,
                    handlerId: handlerId,
                    project_id: project_id,
                    sprint_id: sprint_id,
                    env: env
                }

            }).done(function( response ) {
                if(response.success){
//                    toastr.success('Ticket succesvol toegewezen', 'Gelukt!');
                }else{
                    toastr.error('Er ging iets mis', 'Fout');
                }
            });
        });
    });
</script>
    @include('partials.pusher_script')
@endsection