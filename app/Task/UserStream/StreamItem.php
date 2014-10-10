<?php namespace Portico\Task\UserStream;

/**
 * Any item that can be referenced in a user's stream.
 */
interface StreamItem
{
    /**
     * The UID of the stream item.
     *
     * @return int
     */
    public function getStreamId();
} 