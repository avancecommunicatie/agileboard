<li class="task-item {{ ($ticket->priority < 20 ? 'success' : '') }} {{ ($ticket->priority > 19 && $ticket->priority < 40 ? 'warning-element' : '') }} {{ ($ticket->priority > 40 ? 'danger-element' : '') }}" id="{{ $ticket->id }}">
	<strong class="ticket-summary">{{ $ticket->summary }}</strong>
	<div class="hr-line-dashed ticket-description no-padding"></div>
	<p class="ticket-description">{{ $ticket->bugText->description }}</p>
	<div class="agile-detail">
		<span class="pull-right">{!! Form::select2('assign_to_id', $users, ($ticket->user ? $ticket->user->id : false), ['class' => 'ticket-assign-to']) !!}</span>
		<div class="no-padding col-lg-4 col-md-8 col-sm-8 col-xs-10 pull-left">
			<i class="fa fa-clock-o"></i> {{ date('d-m-Y', $ticket->date_submitted) }}
		</div>
		<i class="fa fa-comment-o"></i> {{ $ticket->bugnote->count() }}
	</div>
</li>