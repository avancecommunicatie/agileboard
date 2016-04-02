<script>
$(function() {
    var select_project = $('#select-project');
    var select_sprint = $('#select-sprint');

    select_project.on('change', function() {
        $('#change-project').submit();
    });

    select_sprint.on('change', function() {
        $('#change-sprint').submit();
    });
});
</script>