<p class="text-muted stream-entry-date">5 hours ago</p>
<h1 class="stream-entry-header">
    <a href="#">{{{ $entry->ticket->reporter->present()->full_name }}}</a> created a ticket <a href="#">{{{ $entry->ticket->present()->stream_name }}}</a></h1>

<div class="stream-entry-description media">
    <a class="pull-left" href="#">
        <img src="{{$entry->ticket->reporter->present()->gravatar_url}}" class="img-circle stream-entry-image"/>
    </a>

    <div class="media-body">
        {{{ $entry->ticket->description }}}
    </div>
</div>
