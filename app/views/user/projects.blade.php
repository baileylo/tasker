@extends('layout.master')

@section('title') My Projects @stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1>My Projects</h1>
    </div>
</div>

<div class="row">
    @foreach($projects as $project)
        <div class="col-lg-12 item-list-indepth">
            <div class="item-list-indepth-description">
                <h1 class="item-list-indepth-header">
                    {{{ $project->name }}}
                </h1>
                <h4 class="item-list-indepth-subheader">
                    Last Updated: <a href="#">2014-05-21</a>
                </h4>
                <p class="item-list-indepth-message">
                    {{{ $project->description }}}
                </p>
                <div class="item-list-indepth-action-items">
                    <a href="{{{ route('project.view', $project->id) }}}" class="btn btn-success">
                        <span class="glyphicon glyphicon-eye-open"></span> View
                    </a>
                    <a href="#" class="btn btn-warning">
                        <span class="glyphicon glyphicon-trash"></span> Unsubscribe
                    </a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    @endforeach
</div>


@stop