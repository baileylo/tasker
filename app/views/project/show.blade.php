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
    <div class="col-lg-12">
        <h3>Latest Tickets</h3>
        @if(!$project->tickets->count())
            <p>There are not any tickets yet!</p>
        @else
            <ul>
                @foreach($project->tickets as $ticket)
                    <li><a href="{{ route('ticket.view', [$ticket->project_id, $ticket->id]) }}">{{{ $ticket->name }}}</a></li>
                @endforeach
            </ul>
        @endif

    </div>
</div>

@stop