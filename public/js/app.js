(function() {
    var pusher = new Pusher('PUBLICKEY')


    var channel = pusher.subscribe('refreshChannel');

    channel.bind('changeStatus', function(data) {
        // data is 3e argument backend, []

        // Refresh pagina met ajax
        location.reload();
    });

    channel.bind('changeHandler', function(data) {
        // data is 3e argument backend, []

        // Refresh pagina met ajax
        location.reload();
    });

})();