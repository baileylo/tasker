@extends('layout.master')

@section('title') Register a New Account @stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1>New Account Registration</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        {{ Form::open(["role" => "form"]) }}
            <div class="form-group @if($errors->has('email')) has-error @endif">
                {{ Form::label('Email') }}

                @if($errors->has('email'))
                    <p class="text-danger">{{ $errors->first('email') }}</p>
                @endif

                {{ Form::text('email', $email, ['class' => 'form-control', 'readonly' => 'readonly']) }}
            </div>

        <div class="form-group @if($errors->has('first_name')) has-error @endif">
            {{ Form::label('First Name') }}

            @if($errors->has('first_name'))
                <p class="text-danger">{{ $errors->first('first_name') }}</p>
            @endif

            {{ Form::text('first_name', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group @if($errors->has('last_name')) has-error @endif">
            {{ Form::label('Last Name') }}

            @if($errors->has('last_name'))
                <p class="text-danger">{{ $errors->first('last_name') }}</p>
            @endif

            {{ Form::text('last_name', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            <button type="submit" name="submission_type" value="view" class="btn btn-primary">Register</button>
            <a href="{{ route('home') }}" class="btn btn-danger">Cancel</a>
        </div>
        {{ Form::close() }}
    </div>
</div>

@stop