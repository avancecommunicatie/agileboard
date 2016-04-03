<script>
    $(function() {
        $('.handle').css('cursor', 'default');

        $('.description-btn').on('click', function() {
            $(this).toggleClass('fa-angle-double-down fa-angle-double-up');
            $(this).siblings('.handle').children('.ticket-description').toggle('slide', { direction: "left"}, 500);
        });

        $('.new-story').click(function(e) {
            e.preventDefault();
            var ibox = $(this).parent('div.ibox');
            var button = $(this).find('i.collapse-icon');
            var content = ibox.find('div.ibox-content');
            ibox.toggleClass('collapsed-new-story');
            content.slideToggle(200);
            button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
            ibox.toggleClass('').toggleClass('border-bottom');
            setTimeout(function () {
                ibox.resize();
                ibox.find('[id^=map-]').resize();
            }, 50);
        });

        $('#delete-story').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                title: "Let op!",
                text: "Weet je zeker dat je deze Story wilt verwijderen?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Verwijder!",
                closeOnConfirm: true
            }, function() {
                form.submit();
            });
        });
    });
</script>