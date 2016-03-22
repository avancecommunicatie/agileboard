<script type="text/javascript">
    var user = "{{ str_random(8).date('dHis') }}";
    var project_id = '{{ $project->id }}';
    var sprint_id = '{{ $sprintId }}';
    var env = '{{ env('APP_ENV') }}';

    $(function() {
        var description_btn = $('.description-btn');
        var select_project = $('#select-project');
        var select_sprint = $('#select-sprint');
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
                    if(!response.success){
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
                if(!response.success){
                    toastr.error('Er ging iets mis', 'Fout');
                }
            });
        });

        select_project.on('change', function() {
            $('#change-project').submit();
        });

        select_sprint.on('change', function() {
            $('#change-sprint').submit();
        });
    });

    setTimeout(function(){
        location.reload();
    }, 300000);
</script>