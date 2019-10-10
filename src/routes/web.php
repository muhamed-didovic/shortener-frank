<?php

Route::post('short', 'LinkController@store');
Route::get('short', 'LinkController@show');
Route::get('stats', 'LinkStatsController@show');

//ROUTE for vue
Route::get('/{any?}', 'SinglePageController@show')->where('any', '.*');
