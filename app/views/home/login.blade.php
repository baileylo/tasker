@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-lg-push-3 col-lg-6">
        <h1>Tasker &mdash; Login &amp; Registration</h1>
        <p>
            Tasker uses <a href="https://login.persona.org/" target="_blank"> Mozilla's Persona</a> for all user authentication.
            Don't have an account with Persona yet, just click <em>Sign In</em>.
        </p>
        <a href="#" class="btn-primary btn-lg btn-block text-center signin">Sign in with Persona!</a>
    </div>
</div>
@stop