@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1><a href="{{{ route('project.view', $ticket->project->id) }}}">{{ $ticket->project->name }}</a> &mdash; {{ $ticket->name }}</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        Open on <em>{{ $ticket->created_at->format('Y-m-d') }}</em> by <em>{{ $ticket->reporter->present()->full_name }}</em>
    </div>
    <div class="col-lg-4">
        Status: @if($ticket->isOpen()) Open @else Closed @endif &mdash; {{ $ticket->present()->status }}
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <p>{{ nl2br(e($ticket->description)) }}</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <a href="#" class="btn btn-lg btn-danger">Close Ticket</a>
    </div>
</div>

<div id="close-ticket-form">
    <div class="row">
        <div class="col-lg-12">
            <h4>Close Ticket</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            {{ Form::open(["role" => "form", 'action' => ['ticket.close', $ticket->project_id, $ticket->id]]) }}
            <div class="form-group @if($errors->has('status')) has-error @endif">
                {{ Form::label('Status:') }}

                @if($errors->has('status'))
                <p class="text-danger">{{ $errors->first('status') }}</p>
                @endif

                {{ Form::select('status', Task\Model\Ticket\Status::readableClosed(), null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group @if($errors->has('comment')) has-error @endif">
                {{ Form::label('Message:') }}

                @if($errors->has('comment'))
                <p class="text-danger">{{ $errors->first('comment') }}</p>
                @endif

                {{ Form::textarea('comment', null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Close</button>
                <a href="#" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>
</div>

@stop