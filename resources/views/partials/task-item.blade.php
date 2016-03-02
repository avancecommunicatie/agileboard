<li class="drag-box task-item {{ ($ticket->priority <= 30 ? 'success-element' : '') }} {{ ($ticket->priority > 30 && $ticket->priority <= 40 ? 'warning-element' : '') }} {{ ($ticket->priority > 40 ? 'danger-element' : '') }}" id="{{ $ticket->id }}">
	<i class="pull-right fa fa-angle-double-down fa-lg description-btn"></i>
	<div class="clearfix handle">
		<strong class="ticket-summary">{{ $ticket->summary }}</strong>
		<div class="hr-line-dashed ticket-description no-padding"></div>
		<p class="ticket-description">{{ $ticket->bugText->description }}</p>
	</div>
	<div class="hr-line-dashed no-padding"></div>
	<div class="agile-detail">
		<div class="row">
			<div class="col-lg-4 col-md-8 col-sm-8 col-xs-10" style="margin-top: 4px; padding-right: 0;">
				<i class="fa fa-clock-o"></i> {{ date('d-m-Y', $ticket->date_submitted) }}
			</div>
			<div class="no-padding col-lg-1" style="margin-top: 4px;">
				<i class="fa fa-comment-o"></i> {{ $ticket->bugnote->count() }}
			</div>
			<div class="no-padding col-lg-offset-1 col-lg-2" style="margin-top: 1px;">
				<a href="http://in2008.nl/mantis/view.php?id={{ $ticket->id }}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> Ticket</a>
			</div>
			<div class="col-lg-4" style="padding-left: 5px;">
				{!! Form::select('assign_to_id', $users, ($ticket->user ? $ticket->user->id : false), ['class' => 'ticket-assign-to']) !!}
			</div>
		</div>
	</div>
</li>