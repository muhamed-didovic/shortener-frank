<?php

declare(strict_types=1);
/*
 * This file is part of Laravel Exceptions.
 *
 * (c) Muhamed Didovic <muhamed.didovic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    /*
     * Name of table where the links or the URLs should be stored
     */
    'table'  => 'links',

    /*
     * Url that should be used with the shortened string
     */
    'url'    => env('APP_URL', 'http://frank.test'),

    /*
     * Routes used in the package
     */
    'routes' => [
        /*
         * Route used to store url with post request
         */
        'post_short_route' => 'short',

        /*
         * Route to get shortend url with get request
         */
        'get_short_route'  => 'short',

        /*
         * Route to get status of url provided with get request
         */
        'get_stats_route'  => 'stats',

        /*
         * Route to serve Vue instance
         */
        'vue_route'        => '{any?}',
    ],
];
