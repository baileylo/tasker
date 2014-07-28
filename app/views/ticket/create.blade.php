@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1><a href="{{{ route('project.view', $project->id) }}}">{{ $project->name }}</a> &mdash; Open Ticket</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        {{ Form::open(["role" => "form"]) }}
        <div class="form-group @if($errors->has('name')) has-error @endif">
            {{ Form::label('Title') }}

            @if($errors->has('name'))
                <p class="text-danger">{{ $errors->first('name') }}</p>
            @endif

            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'A sentence description']) }}
        </div>

        <div class="form-group @if($errors->has('type')) has-error @endif">
            {{ Form::label('Type') }}

            @if($errors->has('type'))
                <p class="text-danger">{{ $errors->first('type') }}</p>
            @endif

            {{ Form::select('type', Task\Model\Ticket\Type::readable(), null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group @if($errors->has('description')) has-error @endif">
            {{ Form::label('Description') }}

            @if($errors->has('description'))
                <p class="text-danger">{{ $errors->first('description') }}</p>
            @endif

            {{ Form::textarea('description', null, ['class' => 'form-control', 'spellcheck' => 'true']) }}
        </div>

        <div class="form-group @if($errors->has('due_date')) has-error @endif">
            {{ Form::label('Due Date') }}

            @if($errors->has('due_date'))
                <p class="text-danger">{{ $errors->first('due_date') }}</p>
            @endif

            {{ Form::input('date', 'due_date', null, ['class' => 'form-control', 'placeholder' => 'YYYY-MM-DD', 'min' => date('Y-m-d')]) }}
        </div>

        <div class="form-group">
            <button type="submit" name="submission_type" value="view" class="btn btn-primary">Create</button>
            <button type="submit" name="submission_type" value="create_another" class="btn btn-success">Create Another</button>
            <a href="{{ route('project.view', $project->id) }}" class="btn btn-danger">Cancel</a>
        </div>
        {{ Form::close() }}
    </div>
</div>

@stop