@if($entry->type == \Portico\Task\UserStream\UserStream::TYPE_TICKET_CLOSED)
    @include('partials.stream-items.close-ticket', ['ticket' => $entry->ticket])
@elseif($entry->type == \Portico\Task\UserStream\UserStream::TYPE_TICKET_CREATED)
    @include('partials.stream-items.create-ticket', ['ticket' => $entry->ticket])
@elseif($entry->type == \Portico\Task\UserStream\UserStream::TYPE_TICKET_UPDATED)
    @include('partials.stream-items.update-ticket', ['ticket' => $entry->ticket])
@endif