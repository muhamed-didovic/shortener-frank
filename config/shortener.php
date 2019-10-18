<?php
return [

    'table'      => 'links',
    'url'        => env('APP_URL', 'http://frank.test'),
    'routes'     => [
        'post_short_route' => 'short',
        'get_short_route'  => 'short',
        'get_stats_route'  => 'stats',
        'vue_route'        => '{any?}',
    ],
];
