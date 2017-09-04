<script>
	$(function() {
        Pusher.logToConsole = true;
		var pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
            cluster: 'eu',
            encrypted: false
        });

		var channel = pusher.subscribe('refreshChannel'+projectgroup_id+sprint_id+env);

		channel.bind('changeStatus', function(data) {
            $('#'+data.id+' .ticket-assign-to').val(data.handler);
            if (data.user != user) {
                $('#'+data.id).prependTo('#'+data.drop_id);
            }
            $('.changed-item').removeClass('changed-item');

            $('#'+data.id).addClass('changed-item');

		    // Ticket count
		    var $target_ticket_count_label = $('#'+data.drop_id+'-ticket-count');
            var $src_ticket_count_label = $('#'+data.src_id+'-ticket-count');
            var target_ticket_count = parseInt($target_ticket_count_label.text());
            var src_ticket_count = parseInt($src_ticket_count_label.text());

            // Ticket counter
            $target_ticket_count_label.text(target_ticket_count+1);
            $src_ticket_count_label.text(src_ticket_count-1);

            // Estimated time
            var ticket_est_time = parseFloat($('#'+data.id).find('span.ticket-est-time').text());
            var $target_est_time_label = $('#'+data.drop_id +'-est-time-label');
            var $target_est_time = $target_est_time_label.find('.est-time-val');
            var target_est_time_val = parseFloat($target_est_time.text());
            var $src_est_time_label = $('#'+data.src_id +'-est-time-label');
            var $src_est_time = $src_est_time_label.find('.est-time-val');
            var src_est_time_val = parseFloat($src_est_time.text());

            if (isNaN(ticket_est_time)) {
                ticket_est_time = 0;
            }

            var target_outcome = (target_est_time_val + ticket_est_time).toFixed(2).toString();
            var src_outcome = (src_est_time_val - ticket_est_time).toFixed(2).toString();
            var target_split = target_outcome.split('.');
            var src_split = src_outcome.split('.');
            var target_decimals = 0;
            var src_decimals = 0;
            var target_decimals_len = 0;
            var src_decimals_len = 0;

            if (target_split && target_split.length > 1) {
                target_decimals = target_split.splice(1, 2);
                target_decimals_len = target_decimals[0].toString().length;
            }
            if (src_split && src_split.length > 1) {
                src_decimals = src_split.splice(1,2);
                src_decimals_len = src_decimals[0].toString().length;
            }

            // Float or integer
            if (target_decimals_len > 1 && target_decimals != 0 && (parseInt(target_decimals) % 10 > 0)) {
                target_outcome = parseFloat(target_outcome).toFixed(2);
            } else if (target_decimals_len > 0 && (parseInt(target_decimals) % 10 === 0) && target_decimals != 0) {
                target_outcome = parseFloat(target_outcome).toFixed(1);
            } else {
                target_outcome = parseInt(target_outcome);
            }
            if (src_decimals_len > 1 && src_decimals != 0 && (parseInt(src_decimals) % 10 > 0)) {
                src_outcome = parseFloat(src_outcome).toFixed(2);
            } else if (src_decimals_len > 0 && (parseInt(src_decimals) % 10 === 0) && src_decimals != 0) {
                src_outcome = parseFloat(src_outcome).toFixed(1);
            } else {
                src_outcome = parseInt(src_outcome);
            }

            // Update values
            $target_est_time.text(target_outcome);
            $src_est_time.text(src_outcome);

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