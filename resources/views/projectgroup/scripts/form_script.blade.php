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

        @if ($projectgroup->id)
        $('#delete-projectgroup-btn').on('click', function(e) {
            e.preventDefault();
            var token = '{{ csrf_token() }}';
            var id = {{ $projectgroup->id }};
            swal({
                title: "Let op!",
                text: "Bij het verwijderen van dit project verwijder je ook alle bijbehorende Stories. Weet je zeker dat je dit Agile Project wilt verwijderen?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Verwijder!",
                closeOnConfirm: false
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('projectgroup.destroy', '') }}/' + id,
                        data: {
                            _method: 'DELETE',
                            _token: token
                        },
                        success: function(response) {
                            if (response.success) {
                                swal({
                                    title: 'Verwijderd',
                                    text: 'Agile project is verwijderd',
                                    type: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "Ok!"
                                }, function(isConfirm) {
                                    if (isConfirm) {
                                        window.location.replace('{{ route('projectgroup.index') }}');
                                    }
                                });
                            } else {
                                toastr.error('Kan project niet verwijderen');
                            }
                        },
                        error: function() {
                            toastr.error('Er ging iets mis!');
                        }
                    });
                }
            });
        });
        @endif
    });
</script>