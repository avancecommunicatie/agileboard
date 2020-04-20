<script type="text/javascript">
    $('.checkbox').click(function () {
        var ticket = $(this).data('ticket');
        var checkboxes = [];
        $('.' + ticket +":checked").each(function() {
            checkboxes.push($(this).val());
        });

        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            url: '{{ route('taskboard.additional-checkbox') }}',
            data: {
                'checkboxes': checkboxes,
                'ticket_id': ticket
            },
            success: function(data)
            {
                //
            }
        });
    });
</script>