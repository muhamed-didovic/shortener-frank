<?php
return [
    /**
     * Name of table where links should be stored
     */
    'table'      => 'links',

    /**
     * Url that should be used with shortened string
     */
    'url'        => env('APP_URL', 'http://frank.test'),

    /**
     * Routes used in package
     */
    'routes'     => [
        /**
         * Route used to store url
         */
        'post_short_route' => 'short',

        /**
         * Rotued to get shortend url
         */
        'get_short_route'  => 'short',

        /**
         * Route to get status of url provided
         */
        'get_stats_route'  => 'stats',

        /**
         * Route to serve Vue instance 
         */
        'vue_route'        => '{any?}',
    ],
];
