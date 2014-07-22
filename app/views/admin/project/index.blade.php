@extends('layout.master')

@section('content')

<div class="row">
    <div class="col-lg-10">
        <h1>Project Admin</h1>
    </div>

    <div class="col-lg-2">
        <a href="{{ route('project.create') }}" title="Create new project" class="btn btn-success">Create New Project</a>
    </div>
</div>

@if (Session::has('notification'))
    <div class="row">
        <div class="col-lg-6 col-lg-push-3">
            <div class="well alert-info">{{ Session::get('notification') }}</div>
        </div>
    </div>
@endif (Session::has('notification'))

<div class="row">
    <div class="col-lg-12 table">
        <table class="table-bordered table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->present()->shortDescription }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('project.view', [$project->id]) }}">View</a>
                            <a class="btn btn-sm btn-warning" href="{{ route('project.edit', [$project->id]) }}">Edit</a>
                            <a class="btn btn-sm btn-danger" href="{{ route('project.delete', [$project->id]) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@stop