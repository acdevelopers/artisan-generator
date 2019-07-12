<?php

/*
|--------------------------------------------------------------------------
| AcDevelopers Repository Config
|--------------------------------------------------------------------------
|
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | AcDevelopers Repository Config
    |--------------------------------------------------------------------------
    |
    |
    */

    'basePath'      => app()->path(),

    /*
    |--------------------------------------------------------------------------
    | AcDevelopers Repository Config
    |--------------------------------------------------------------------------
    |
    |
    */

    'rootNamespace' => 'App\\',

    /*
    |--------------------------------------------------------------------------
    | AcDevelopers Repository Config
    |--------------------------------------------------------------------------
    |
    |
    */

    'namespaces'       => [
        'channels'      => '\Broadcasting',
        'commands'      => '\Console\Commands',
        'controllers'   => '\Http\Controllers',
        'events'        => '\Events',
        'exceptions'    => '\Exceptions',
        'jobs'          => '\Jobs',
        'listeners'     => '\Listeners',
        'mail'          => '\Mail',
        'middleware'    => '\Http\Middleware',
        'models'        => '',
        'notifications' => '\Notifications',
        'observers'     => '\Observers',
        'policies'      => '\Policies',
        'providers'     => '\Providers',
        'requests'      => '\Http\Requests',
        'resources'     => '\Http\Resources',
        'rules'         => '\Rules'
    ],

    'request-extra-model-params' => true,
];
