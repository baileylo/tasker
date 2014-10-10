<?php namespace Portico\Task\UserStream;

use Portico\Task\User\User;

class UserStreamFactory
{
    /**
     * Creates a new stream entry for a given user.
     *
     * @param User       $user          User whose stream this should be inserted into
     * @param StreamItem $item          Reference item to insert into the stream
     * @param int        $streamType    Type of entry
     *
     * @return UserStream
     */
    public function make(User $user, StreamItem $item, $streamType)
    {
        $streamEntry = new UserStream();
        $streamEntry->user_id = $user->id;
        $streamEntry->object_id = $item->getStreamId();
        $streamEntry->type = $streamType;

        return $streamEntry;
    }
} 