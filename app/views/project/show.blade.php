@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <h1>{{{ $project->name }}}</h1>
    </div>

    <div class="col-lg-2">
        <a href="{{{ route('ticket.create', [$project->id]) }}}" title="Open Ticket" class="btn btn-success">Open Ticket</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <p>{{{ $project->description }}}</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <h3>Latest Tickets</h3>
        @if(!$open->count())
            <p>There are no open tickets.</p>
        @else
            <ul>
                @foreach($open as $ticket)
                    <li><a href="{{ route('ticket.view', [$ticket->project_id, $ticket->id]) }}">{{{ $ticket->name }}}</a></li>
                @endforeach
            </ul>
        @endif

    </div>

    <div class="col-lg-4">
        <h3>Due Soon</h3>
        @if(!$upcoming->count())
            <p>There are no open tickets with a due date.</p>
        @else
        <ul>
            @foreach($upcoming as $ticket)
            <li><a href="{{ route('ticket.view', [$ticket->project_id, $ticket->id]) }}">{{{ $ticket->name }}}</a></li>
            @endforeach
        </ul>
        @endif

    </div>

    <div class="col-lg-4">
        <h3>Recently Closed Tickets</h3>
        @if(!$closed->count())
            <p>No tickets have been closed yet.</p>
        @else
        <ul>
            @foreach($closed as $ticket)
            <li><a href="{{ route('ticket.view', [$ticket->project_id, $ticket->id]) }}">{{{ $ticket->name }}}</a></li>
            @endforeach
        </ul>
        @endif

    </div>
</div>

@stop