<?php

Route::group(
    [
        'namespace'  => 'MuhamedDidovic\Shortener\Controllers',
        'middleware' => 'MuhamedDidovic\Shortener\Middleware\ModifiesUrlRequestData',
    ],
    function () {
        //save url
        Route::post(config('shortener.routes.post_short_route'), 'LinkController@store');
        //get url
        Route::get(config('shortener.routes.get_short_route'), 'LinkController@show');
        //get stats
        Route::get(config('shortener.routes.get_stats_route'), 'LinkStatsController@show');
        //ROUTE for vue
        Route::get(config('shortener.routes.vue_route'), 'SinglePageController@show')->where('any', '.*');
    }
);
