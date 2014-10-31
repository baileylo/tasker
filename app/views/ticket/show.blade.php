@extends('layout.master')

@section('title') {{{ $ticket->name }}} - {{{ $ticket->project->name }}} @stop

@section('js')toggle datePicker viewTicket typeahead-usersearch @stop

@section('content')
{{ Form::open(["role" => "form", 'class' => $helper->fieldToggle(), 'route' => ['ticket.edit', $ticket->project->id, $ticket->id]]) }}
    <div class="row">
        <div class="col-lg-12 page-header">
            <h1>
                <span class="ticket-details" style="display: block;">{{{ $ticket->name }}}</span>
                {{ Form::text('name', $ticket->name, ['class' => 'form-control ticket-edit-form hidden', 'placeholder' => 'A sentence description']) }}

                <small>Opened on <em>{{ $ticket->created_at->format('Y-m-d') }}</em> by <em>{{ $ticket->reporter->present()->full_name }}</em></small>
            </h1>

        </div>
    </div>

    <div class="well">
        <div class="row">
            <div class="col-lg-6">
                <dl class="dl-horizontal">
                    <dt class="form-group">{{ Form::label('status') }}</dt>
                    <dd class="ticket-details">{{ $ticket->present()->general_status }} &mdash; {{ $ticket->present()->status }}</dd>
                    <dd class="ticket-edit-form {{ $helper->editFormClasses('status') }}">{{ Form::select('status', Portico\Task\Ticket\Enum\Status::readable(), $ticket->status, ['class' => 'form-control']) }}</dd>
                    {{ $helper->renderErrorMessage('status') }}

                    <dt class="form-group">{{ Form::label('assignee') }}</dt>
                    <dd class="ticket-edit-form">{{ Form::text('assignee', $ticket->assignee ? $ticket->assignee->present()->full_name : '', ['class' => 'form-control user-search', 'data-id-selector' => '#input_assignee_id', 'data-starting-value' => $ticket->assignee ? $ticket->assignee->present()->full_name : '']) }}</dd>
                    <dd class="hidden">{{ Form::text('assignee_id', $ticket->assignee_id, ['class' => 'form-control', 'id' => 'input_assignee_id']) }}</dd>
                    <dd class="ticket-details {{ $helper->editFormClasses('assignee') }}">{{ $helper->getAssigneesName($ticket->assignee, '&mdash;') }}</dd>
                    {{ $helper->renderErrorMessage('assignee_id') }}

                    <dt class="form-group">{{ Form::label('type') }}</dt>
                    <dd class="ticket-details {{ $helper->editFormClasses('type') }}"> {{ $ticket->present()->type }} </dd>
                    <dd class="ticket-edit-form">{{ Form::select('type', Portico\Task\Ticket\Enum\Type::readable(), $ticket->type, ['class' => 'form-control']) }}</dd>
                    {{ $helper->renderErrorMessage('type') }}

                    <dt class="form-group">{{ Form::label('Target Release') }}</dt>
                    <dd class="ticket-details {{ $helper->editFormClasses('target_release') }}"><em>Coming soon</em></dd>
                    <dd class="ticket-edit-form"><em>Coming soon</em></dd>
                </dl>
            </div>

            <div class="col-lg-6">
                <dl class="dl-horizontal">
                    <dt class="form-group">{{ Form::label('Start Date') }}</dt>
                    <dd class="ticket-details {{ $helper->editFormClasses('start_date') }}"><em>Coming soon</em></dd>
                    <dd class="ticket-edit-form"><em>Coming soon</em></dd>

                    <dt class="form-group">{{ Form::label('Due Date') }}</dt>
                    <dd class="ticket-details {{ $helper->editFormClasses('due_date') }}">{{ $helper->something($ticket->due_date, '&mdash;')->format('Y-m-d') }}</dd>
                    <dd class="ticket-edit-form">{{ Form::input('date', 'due_date', $helper->something($ticket->due_date)->format('Y-m-d'), ['class' => 'form-control datepicker', 'placeholder' => 'YYYY-MM-DD', 'min' => date('Y-m-d')]) }}</dd>
                    {{ $helper->renderErrorMessage('due_date') }}

                    <dt class="form-group">{{ Form::label('Percent Complete') }}</dt>
                    <dd class="ticket-details {{ $helper->editFormClasses('percent_complete') }}"><em>Coming soon</em></dd>
                    <dd class="ticket-edit-form"><em>Coming soon</em></dd>
                </dl>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <b>Description:</b><br />
                {{ $helper->renderErrorMessage('description', '<p class="text-danger">%s</p>') }}
                <p class="ticket-details">{{ nl2br(e($ticket->description)) }}</p>
                <p class="ticket-edit-form {{ $helper->editFormClasses('description') }}">{{ Form::textarea('description', $ticket->description, ['class' => 'form-control', 'spellcheck' => 'true']) }}</p>
            </div>
        </div>
    </div>

    <div class="row ticket-edit-form">
        <div class="col-lg-12">
            <div class="form-group {{ $helper->editFormClasses('comment') }}">
                {{ Form::label('Message(optional):') }}

                {{ $helper->renderErrorMessage('comment', '<p class="text-danger">%s</p>') }}
                {{ Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => 'Explanation of edits']) }}
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="#" class="btn btn-danger toggleable" data-hide-selector=".ticket-edit-form" data-toggle-selector=".ticket-details">Cancel</a>
            </div>

        </div>
    </div>

    <div class="row ticket-details" id="close-button-wrapper">
        <div class="col-lg-12 right">
            <a href="#" class="btn btn-warning toggleable" data-hide-selector=".ticket-details" data-toggle-selector=".ticket-edit-form">Edit</a>
        </div>
    </div>
{{ Form::close() }}

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

<div id="add-comment-form">
    <div class="row">
        <div class="col-lg-12">
            <h4>Add Comment</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            {{ Form::open(["role" => "form", 'action' => ['ticket.comment.add', $ticket->project_id, $ticket->id]]) }}

            <div class="form-group @if($commentErrors->has('comment')) has-error @endif">
                @if($commentErrors->has('comment'))
                    <p class="text-danger">{{ $commentErrors->first('comment') }}</p>
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

@stop