@extends('layout.master')

@section('title') {{{ $ticket->name }}} - {{{ $ticket->project->name }}} @stop

@section('js')toggle @stop

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

<div class="row" id="close-button-wrapper">
    <div class="col-lg-12">
        <a href="#" class="btn btn-lg btn-danger toggleable" data-hide-selector="#close-button-wrapper" data-toggle-selector="#close-ticket-form">Close Ticket</a>
    </div>
</div>

<div id="close-ticket-form" class="hidden">
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

                {{ Form::select('status', \Portico\Task\Ticket\Enum\Status::readableClosed(), null, ['class' => 'form-control']) }}
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
                <a href="#" class="btn btn-danger toggleable" data-toggle-selector="#close-button-wrapper" data-hide-selector="#close-ticket-form">Cancel</a>
            </div>

            {{ Form::close() }}
        </div>
    </div>
</div>

<div id="add-comment-form">
    <div class="row">
        <div class="col-lg-12">
            <h4>Add Comment</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            {{ Form::open(["role" => "form", 'action' => ['ticket.comment.add', $ticket->project_id, $ticket->id]]) }}

            <div class="form-group @if($errors->has('comment')) has-error @endif">
                @if($errors->has('comment'))
                <p class="text-danger">{{ $errors->first('comment') }}</p>
                @endif

                {{ Form::textarea('comment', null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add Comment</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div id="comments">
    <div class="row">
        <div class="col-lg-12">
            <h4>Comments</h4>
        </div>
    </div>

    @foreach($ticket->comments as $comment)
        <article>
            <div class="row">
                <div class="col-lg-12">
                    {{ $comment->author->present()->full_name }} on <date>{{ $comment->created_at->format('Y-m-d') }}</date>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p>{{{ $comment->message }}}</p>
                </div>
            </div>
        </article>
    @endforeach

</div>

@stop