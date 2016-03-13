<script>
    $(function(){
        resizeBlocks();
        $(window).resize(function(){
            resizeBlocks();
        });
    });

    function resizeBlocks(){
        var windowHeight = $(window).height();
        var headerHeight = $('#taskboard-header').height();
        var paddings = 60+150;

        var newHeight = windowHeight-headerHeight-paddings;

        $('.sortable-list').height(newHeight);
    }
</script>