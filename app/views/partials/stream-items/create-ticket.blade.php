<p class="text-muted">5 hours ago</p>
<h1>{{{ $entry->ticket->reporter->present()->full_name }}} created a ticket {{{ $entry->ticket->present()->stream_name }}}</h1>
<img src="{{$entry->ticket->reporter->present()->gravatar_url}}" class="img-circle"/>
<p>{{{ $entry->ticket->description }}}</p>