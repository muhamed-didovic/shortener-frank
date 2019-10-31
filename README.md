# shortener-frank

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![StyleCI][ico-styleci]][link-styleci]
[![Total Downloads][ico-downloads]][link-downloads]

This Laravel package allows you to shorten a URL, it comes also with frontend part which is done in vue.js and vuex.
You can publish all files like: views, config, migrations this is backend related and for frontend you can publish js and css 
file and change them however you will.

**Basic Docs**

* [Installation](#installation)
* [Configuration](#configuration)
* [Frontend configuration](#fronend-configuration)
* [Usage](#usage)
* [Change log](#change-log)
* [Testing](#testing)
* [Contribution](#contribution)

<a name="installation"></a>

## Installation

Laravel Exceptions requires [PHP](https://php.net) 7.1-7.3. This particular version supports Laravel 5.5-5.8 and 6 only.

To get the latest version, simply require the project using [Composer](https://getcomposer.org):

Via Composer

``` bash
$ composer require muhamed-didovic/shortener-frank
```

Once installed, if you are not using automatic package discovery, then you need to register the `MuhamedDidovic\Shortener\ShortenerServiceProvider` service provider in your `config/app.php` like this:

```php
'providers' => [
    ...
    MuhamedDidovic\Shortener\ShortenerServiceProvider::class
]    
``` 

You can also optionally alias our facade:

```php
'aliases' => [
    ...
    'Shortener' => MuhamedDidovic\\Shortener\\Facades\\Shortener::class
]    
``` 

<a name="configuration"></a>

## Configuration

Laravel Shortener package supports optional configuration.

You can publish the migration with:

```bash
php artisan vendor:publish --provider="MuhamedDidovic\Shortener\ShortenerServiceProvider" --tag="shortener::migrations"
```

After the migration has been published you can create the media-table by running the migrations:

```bash
php artisan migrate
```

You can publish the config-file with:

```bash
php artisan vendor:publish --provider="MuhamedDidovic\Shortener\ShortenerServiceProvider" --tag="shortener::config"
```

This is the contents of the published config file:

```php
return [
    /*
     * Name of table where links or URLs should be stored
     */
    'table'  => 'links',

    /*
     * Url that should be used with shortened string
     */
    'url'    => env('APP_URL', 'http://frank.test'),

    /*
     * Routes used in package
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
    ]
];
```

Frontend configuration

If there is need to change or configure something in frontend (js, css, view files) you need to do the following:

<a name="frontend-configuration"></a>

Frontend Configuration

### 1st step

you need to publish frontend files(js, css and view) first:

```bash
php artisan vendor:publish --provider="MuhamedDidovic\Shortener\ShortenerServiceProvider" --tag="shortener::views"
php artisan vendor:publish --provider="MuhamedDidovic\Shortener\ShortenerServiceProvider" --tag="shortener::assets"
```

The first command above is for view file and it will be placed in `resources/views/vendor/` folder with the name: `shortener.blade.php`

It should be like this:

<img src="https://raw.githubusercontent.com/muhamed-didovic/shortener-frank/master/docs/view.png" width="200">


Second command is publishing js and css into `resources` and `public` folder.

This is needed when we make changes to js or css files in `resources` folder, those files will be bundled and placed inside `public` folder

js and css files in `resources` folder should look like this:

<img src="https://raw.githubusercontent.com/muhamed-didovic/shortener-frank/master/docs/resources.png" width="200">
 
Besides files in resources folder there are two more files `shortener.js` and `shortener.css` that will be placed inside public folder:

<img src="https://raw.githubusercontent.com/muhamed-didovic/shortener-frank/master/docs/public.png" width="200">

### 2nd step

you need to install npm dependencies in package.json file

```bash
npm install vue-template-compiler@2.6.10 clipboard@1.6.1 pluralize@4.0.0 vue@2.2.6 vue-axios@2.1.4 vue-router@2.3.1 vuex@2.3.1 --save-dev
```

### 3rd step
 
you need to add files to bundle in webpack.mix.js

```js
mix.js('resources/js/shortener.js', 'public/js/shortener.js')
    .sass('resources/sass/shortener.scss', 'public/css/shortener.css');
```

### 4th step

run the laravel mix, you can check package.json in `scripts` part for commands like

```bash
npm run dev
```
 
 or watcher
 
 ```bash
 npm run watch
 ```

<a name="usage"></a>

## Usage

In order to use this package in your application there are 4 routes in web.php file that you need to get familiar

Below is web.php file where are the routes

```php
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
```

All endpoints routes are stored inside of shortener.php config file.
First three routes are more API based and return JSON results.

First two routes from web.php have `short` default endpoint, first one is used to store and shorten URL, second is used to retrieve URL by code what we provide.
Third route have `stats` default endpoint and is used to get stats for particualar URL.

Last fourth route (`/` is default endpoint) and is used for Vue.js to show view. 

### Important Node
Because there is `/` route to show view with the form element and probably it is used already in your project so you can change
in shortener.php config file that route with endpoint that you want or you can comment/remove your `/` route 
  
<a name="change-log"></a>  
  
## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

<a name="testing"></a>

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email muhamed.didovic@gmail.com instead of using the issue tracker.

## Credits

- [Muhamed Didovic][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/muhamed-didovic/shortener-frank.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/muhamed-didovic/shortener-frank/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/muhamed-didovic/shortener-frank.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/muhamed-didovic/shortener-frank.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/muhamed-didovic/shortener-frank.svg?style=flat-square
[ico-styleci]: https://github.styleci.io/repos/214193290/shield?branch=master

[link-packagist]: https://packagist.org/packages/muhamed-didovic/shortener-frank
[link-travis]: https://travis-ci.org/muhamed-didovic/shortener-frank
[link-scrutinizer]: https://scrutinizer-ci.com/g/muhamed-didovic/shortener-frank/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/muhamed-didovic/shortener-frank
[link-downloads]: https://packagist.org/packages/muhamed-didovic/shortener-frank
[link-author]: https://github.com/muhamed-didovic
[link-contributors]: ../../contributors
[link-styleci]: https://github.styleci.io/repos/214193290

