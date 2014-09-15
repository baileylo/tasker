@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-8">

            @foreach($streamItems as $streamItem)
                <article class="row stream-entry">
                    @include('partials.stream-item', ['entry' => $streamItem])
                </article>
            @endforeach

            @if($streamItems->isEmpty())
                <p class="text-muted text-center">There is nothing your stream.</p>
            @endif

        </div>
        <div class="col-lg-4">
            @include('home.partials.sidebar-module', ['title' => 'Recently Updated Tickets', 'tickets' => $updatedTickets, 'message' => 'There are no recently updated tickets.'])
            @include('home.partials.sidebar-module', ['title' => 'New Tickets', 'tickets' => $newTickets, 'message' => 'There are no new tickets.'])

            <div class="row">
                <div class="col-lg-12 sidebar-module">
                    <h1 class="sidebar-module-header">My Projects</h1>
                    <ul class="sidebar-module-list">
                        @foreach(Auth::user()->projects as $project)
                            <li><a href="{{{ route('project.view', $project->id) }}}">{{{ $project->name }}}</a></li>
                        @endforeach
                    </ul>

                    @if(Auth::user()->projects->count() > 3)
                        <a href="{{{ route('user.projects') }}}">More</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop