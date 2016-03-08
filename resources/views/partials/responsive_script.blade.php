<script>
    $(document).ready(function() {
       var windowHeight     = window.innerHeight;
       var headerHeight     = $('#taskboard-header').height();
       var taskboardContent = $('#taskboard-content');

       var taskSectionHeight =  windowHeight - headerHeight - taskboardContent.css('padding-top') - taskboardContent.css('padding-bottom');

       console.log(windowHeight);
       console.log(headerHeight);
       console.log(taskSectionHeight);

       $('body').css('max-height', windowHeight);
//       $('.task-section').css('max-height', );
    });
</script>