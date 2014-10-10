<div class="row">
    <div class="col-lg-12 sidebar-module">
        <h1 class="sidebar-module-header">{{{ $title  }}}</h1>
        <ul class="sidebar-module-list">
            @foreach($tickets as $ticket)
                <li><a href="{{{ route('ticket.view', [$ticket->project_id, $ticket->id]) }}}">{{{ $ticket->name }}}</a></li>
            @endforeach

            @if($tickets->isEmpty())
                <li class="text-muted"><em>{{{ $message }}}</em></li>
            @endif
        </ul>
    </div>
</div>