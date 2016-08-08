<script>
	$(function() {
		var pusher = new Pusher('c6ca1d090dec336e071a');
		var channel = pusher.subscribe('refreshChannel'+projectgroup_id+sprint_id+env);

		channel.bind('changeStatus', function(data) {
		    // Ticket count
		    var $target_ticket_count_label = $('#'+data.drop_id+'-ticket-count');
            var $src_ticket_count_label = $('#'+data.src_id+'-ticket-count');
            var target_ticket_count = parseInt($target_ticket_count_label.text());
            var src_ticket_count = parseInt($src_ticket_count_label.text());

            // Estimated time
            var ticket_est_time = parseFloat($('#'+data.id).find('span.ticket-est-time').text());
            var $target_est_time_label = $('#'+data.drop_id +'-est-time-label');
            var $target_est_time = $target_est_time_label.find('.est-time-val');
            var target_est_time_val = parseFloat($target_est_time.text());
            var $src_est_time_label = $('#'+data.src_id +'-est-time-label');
            var $src_est_time = $src_est_time_label.find('.est-time-val');
            var src_est_time_val = parseFloat($src_est_time.text());

			$('#'+data.id+' .ticket-assign-to').val(data.handler);
			if (data.user != user) {
				$('#'+data.id).prependTo('#'+data.drop_id);
			}
			$('.changed-item').removeClass('changed-item');

			$('#'+data.id).addClass('changed-item');

            // Ticket counter
            $target_ticket_count_label.text(target_ticket_count+1);
            $src_ticket_count_label.text(src_ticket_count-1);

            // Estimated time
            $target_est_time.text( target_est_time_val + ticket_est_time );
            $src_est_time.text( src_est_time_val - ticket_est_time );

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