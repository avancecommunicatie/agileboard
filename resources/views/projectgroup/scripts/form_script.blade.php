<script>
    $(function() {
        var search_input = $('#search-input');

        search_input.keydown(function(e) {
            if(event.keyCode == 13) {
                e.preventDefault();
            }
        });

        $('#search-btn').on('click', function(e) {
            e.preventDefault();
        });

        search_input.focus(function() {

            search_input.keyup(function() {
                var value = search_input.val();
                var project = $('input.i-checks');

                $.each(project, function(k,v) {
                    var text = v.value.toUpperCase();

                    if (!text.includes(value.toUpperCase())) {
                        $(this).parents('li').hide();
                    } else {
                        $(this).parents('li').show();
                    }
                });
            });
        });

        $('#delete-projectgroup-btn').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                title: "Let op!",
                text: "Bij het verwijderen van dit project verwijder je ook alle bijbehorende Stories. Weet je zeker dat je dit Agile Project wilt verwijderen?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Verwijder!",
                closeOnConfirm: true
            }, function(isConfirm) {
                if (isConfirm) {
                    form.submit();
                }
            });
        });
    });
</script>