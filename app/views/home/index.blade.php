@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-8">

            @foreach($streamItems as $streamItem)
                <article class="row stream-entry">
                    @include('partials.stream-item', ['entry' => $streamItem])
                </article>
            @endforeach

        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12 sidebar-module">
                    <h1 class="sidebar-module-header">Recently Updated Tickets</h1>
                    <ul class="sidebar-module-list">
                        @foreach($updatedTickets as $ticket)
                            <li><a href="{{{ route('ticket.view', [$ticket->project_id, $ticket->id]) }}}">{{{ $ticket->name }}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 sidebar-module">
                    <h1 class="sidebar-module-header">New Tickets</h1>
                    <ul class="sidebar-module-list">
                        @foreach($newTickets as $ticket)
                            <li><a href="{{{ route('ticket.view', [$ticket->project_id, $ticket->id]) }}}">{{{ $ticket->name }}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 sidebar-module">
                    <h1 class="sidebar-module-header">My Projects</h1>
                    <ul class="sidebar-module-list">
                        @foreach(Auth::user()->projects as $project)
                            <li><a href="{{{ route('project.view', $project->id) }}}">{{{ $project->name }}}</a></li>
                        @endforeach
                    </ul>
                    <a href="{{{ route('user.projects') }}}">More</a>
                </div>
            </div>
        </div>
    </div>
@stop