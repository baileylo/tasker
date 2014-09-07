<?php namespace Portico\Task\Ticket\Enum;

use Task\Service\Enum\Base;

class Status extends Base
{
    const OPEN = 8;
    const WAITING = 9;
    const PROGRESS = 10;
    const REVIEW_REQUIRED = 11;
    const REVIEW = 12;
    const POSTPONED = 13;


    const CLOSED = 0;
    const SOLVED = 1;
    const WONT_FIX = 2;
    const DUPLICATE = 3;

    public static function readable()
    {
        return [
                self::WAITING => 'Waiting',
                self::PROGRESS => 'In Progress',
                self::REVIEW_REQUIRED => 'Review Required',
                self::REVIEW => 'In Review',
                self::POSTPONED => 'Postponed',
            ] +
            self::readableClosed();
    }

    public static function readableClosed()
    {
        return [
            self::SOLVED => 'Resolved',
            self::WONT_FIX => 'Won\'t Fix',
            self::DUPLICATE => 'Duplicate'
        ];
    }
} 