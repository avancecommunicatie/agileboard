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

        })
    });
</script>