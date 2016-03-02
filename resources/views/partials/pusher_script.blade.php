<script>
	$(document).ready(function() {

		var pusher = new Pusher('c6ca1d090dec336e071a');

		var channel = pusher.subscribe('refreshChannel');

		channel.bind('changeStatus', function(data) {
			$('#'+data.id).prependTo('#'+data.drop_id);
			toastr.info('Update plaats gevonden');
		});

		channel.bind('changeHandler', function(data) {
			$('#'+data.id+' .ticket-assign-to').val(data.handler);
			toastr.info('Update plaats gevonden');
		});

	});
</script>