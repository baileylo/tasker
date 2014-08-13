@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <h1>Stream</h1>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12 sidebar-module">
                    <h1 class="sidebar-module-header">Recently Updated Tickets</h1>
                    <ul class="sidebar-module-list">
                        <li><a href="#">Fix login link on landing page</a></li>
                        <li><a href="#">Add email this to ticket button</a></li>
                        <li><a href="#">Update the readme instructions</a></li>
                        <li><a href="#">Optimize DNS prefetching</a></li>
                        <li><a href="#">Build ACL</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 sidebar-module">
                    <h1 class="sidebar-module-header">New Tickets</h1>
                    <ul class="sidebar-module-list">
                        <li><a href="#">Fix typo in user management</a></li>
                        <li><a href="#">Allow Editing of existing tickets</a></li>
                        <li><a href="#">Add ticket versioning</a></li>
                        <li><a href="#">Ajax comment submissions</a></li>
                        <li><a href="#">Long pull for new comments</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 sidebar-module">
                    <h1 class="sidebar-module-header">My Projects</h1>
                    <ul class="sidebar-module-list">
                        @foreach(Auth::user()->projects as $project)
                            <li><a href="{{{ route('project.view', $project->id) }}}">{{{ $project->name }}}</a></li>
                        @endforeach
                    </ul>
                    <a href="{{{ route('user.projects') }}}">More</a>
                </div>
            </div>
        </div>
    </div>
@stop