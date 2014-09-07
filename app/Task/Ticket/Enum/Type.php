<?php namespace Portico\Task\Ticket\Enum;

use Portico\Core\Enum\Base;

class Type extends Base
{
    const FEATURE = 1;
    const BUG = 2;

    public static function readable()
    {
        return [
            self::FEATURE => 'Feature',
            self::BUG => 'Bug'
        ];
    }
} 