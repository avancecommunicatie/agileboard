<script>
	$(document).ready(function() {
		var pusher = new Pusher('c6ca1d090dec336e071a');

		var channel = pusher.subscribe('refreshChannel'+project_id+sprint_id+env);

		channel.bind('changeStatus', function(data) {
			console.log(data);
			$('#'+data.id+' .ticket-assign-to').val(data.handler);
			if (data.user != user) {
				$('#'+data.id).prependTo('#'+data.drop_id);
			}
			$('.changed-item').removeClass('changed-item');

			$('#'+data.id).addClass('changed-item');

			toastr.info('De status van ticket #'+data.id+' is gewijzigd', 'Update!');
		});

		channel.bind('changeHandler', function(data) {
			$('#'+data.id+' .ticket-assign-to').val(data.handler);
			$('.changed-item').removeClass('changed-item');
			$('#'+data.id).addClass('changed-item');
			toastr.info('Ticket #'+data.id+' is toegewezen aan '+data.handlerName, 'Update!');
		});

	});
</script>