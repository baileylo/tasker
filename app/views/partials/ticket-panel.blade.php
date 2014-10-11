<div class="panel panel-default">
    <div class="panel-heading">{{{ $header }}}</div>
    <div class="panel-body">
        @if(!$tickets->count())
            <p>{{{ $emptyMessage }}}</p>
        @else
            <ul>
                @foreach($tickets as $ticket)
                    <li><a href="{{ route('ticket.view', [$ticket->project_id, $ticket->id]) }}">{{{ $ticket->name }}}</a></li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
