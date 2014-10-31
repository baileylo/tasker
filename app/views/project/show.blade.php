@extends('layout.master')

@section('js')project.view @stop


@section('content')
<div class="row">
    <div class="col-lg-12 page-header">
        <div class="pull-right">
            <a href="{{{ route('ticket.create', [$project->id]) }}}" title="Open Ticket" class="btn btn-warning">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
            <a href="{{{ route('project.watch', [$project->id]) }}}" id="watch-project" title="Watch Project" class="btn btn-primary @if(!$user || $user->isWatchingProject($project)) hidden @endif">
                <span class="glyphicon glyphicon-eye-open"></span>
            </a>
            <a href="{{{ route('project.unwatch', [$project->id]) }}}" id="unwatch-project" title="Unwatch Project" class="btn btn-danger @if($user && !$user->isWatchingProject($project)) hidden @endif">
                <span class="glyphicon glyphicon-eye-close"></span>
            </a>
        </div>

        <h1>
            {{{ $project->name }}}<br />
            <small>{{{ $project->description }}}</small>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        @include('partials.ticket-panel', ['header' => 'Latest Tickets', 'emptyMessage' => 'There are no open tickets', 'tickets' => $open])
    </div>

    <div class="col-lg-4">
        @include('partials.ticket-panel', ['header' => 'Due Soon', 'emptyMessage' => 'There are no open tickets with a due date', 'tickets' => $upcoming])
    </div>

    <div class="col-lg-4">
        @include('partials.ticket-panel', ['header' => 'Recently Closed', 'emptyMessage' => 'No tickets have been closed yet', 'tickets' => $closed])
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-3">
                        <span>
                            <span class="glyphicon glyphicon-unchecked"></span>
                            {{{ $project->openTicketCount }}}
                            Open
                        </span>

                        <span style="padding-left:5px;" class="text-muted">
                            <span class="glyphicon glyphicon-check"></span>
                            {{{ $project->closedTicketCount }}}
                            Closed
                        </span>
                    </div>
                    <div class="col-lg-6 col-lg-offset-3">
                        Hello World!
                    </div>
                </div>
            </div>

            <!-- Table -->
            <table class="table table-hover">
                @foreach($tickets as $ticket)
                    <tr>
                        <td><span class="glyphicon glyphicon-unchecked"></span></td>
                        <td>
                            <a class="" href="{{ route('ticket.view', [$ticket->project_id, $ticket->id]) }}">{{{ $ticket->name }}}</a><br />
                            <span class="text-muted">#{{{ $ticket->id }}} open on {{{ $ticket->created_at->format('Y-m-d') }}} by {{{ $ticket->reporter->present()->full_name }}}</span>
                        </td>
                        <td>
                            Comments <span class="badge">{{{ $ticket->commentCount }}}</span>
                        </td>

                    </tr>

                @endforeach
            </table>

            {{ $tickets->links() }}
        </div>
    </div>
</div>

@stop