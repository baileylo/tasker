<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Database Connection Name
    |--------------------------------------------------------------------------
    | Name of the Database Connection, defined below, that will be used by the
    | application.
    */

    'default' => 'mysql',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | List of database connections to use. If you're evaluating Tasker sqlite
    | should be sufficient, though we recommend using mysql or postgres for
    | production installations.
    |
    */

    'connections' => array(

        'sqlite' => array(
            'driver'   => 'sqlite',
            'database' => __DIR__.'/../../database/production.sqlite',
            'prefix'   => '',
        ),

        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'my_database',
            'username'  => 'my_user',
            'password'  => 'my_password',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        )
    )
);
