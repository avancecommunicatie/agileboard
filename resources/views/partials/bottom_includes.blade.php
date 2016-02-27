@section('bottom-includes')
        <!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery-ui-1.10.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>

<!-- Peity demo data -->
<script src="js/demo/peity-demo.js"></script>


<script>
    $(document).ready(function(){

        $("#todo, #inprogress, #feedback, #completed").sortable({
            connectWith: ".connectList",
            update: function( event, ui ) {

                var todo = $( "#todo" ).sortable( "toArray" );
                var inprogress = $( "#inprogress" ).sortable( "toArray" );
                var feedback = $('#feedback').sortable("toArray");
                var completed = $( "#completed" ).sortable( "toArray" );
                $('.output').html("ToDo: " + window.JSON.stringify(todo) + "<br/>" + "In Progress: " + window.JSON.stringify(inprogress) + "Feedback: " + window.JSON.stringify(feedback) + "<br/>" + "Completed: " + window.JSON.stringify(completed));
            }
        }).disableSelection();

    });
</script>
@endsection