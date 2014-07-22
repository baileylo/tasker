@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <h1>Edit Project &mdash; {{{ $project->name }}}</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        {{ Form::model($project, ["role" => "form"]) }}
        <div class="form-group @if($errors->has('name')) has-error @endif">
            {{ Form::label('Name') }}

            @if($errors->has('name'))
            <p class="text-danger">{{ $errors->first('name') }}</p>
            @endif

            {{ Form::text('name', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group @if($errors->has('description')) has-error @endif">
            {{ Form::label('Description') }}

            @if($errors->has('description'))
            <p class="text-danger">{{ $errors->first('description') }}</p>
            @endif

            {{ Form::textarea('description', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.project.index') }}" class="btn btn-danger">Cancel</a>
        </div>
        {{ Form::close() }}
    </div>
</div>

@stop