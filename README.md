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
* [Chain providers](#chain-providers)
* [Retrieve link](#retrieve-link)
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
         * Route used to store url
         */
        'post_short_route' => 'short',

        /*
         * Rotued to get shortend url
         */
        'get_short_route'  => 'short',

        /*
         * Route to get status of url provided
         */
        'get_stats_route'  => 'stats',

        /*
         * Route to serve Vue instance
         */
        'vue_route'        => '{any?}',
    ],
];
```

If there is need to change or configure something in frontend (js, css, view files) you need to do the following:

### 1st step, you need to publish them first:

```bash
php artisan vendor:publish --provider="MuhamedDidovic\Shortener\ShortenerServiceProvider" --tag="shortener::views"
php artisan vendor:publish --provider="MuhamedDidovic\Shortener\ShortenerServiceProvider" --tag="shortener::assets"
```

View file will be placed in `resources/views/vendor/` folder with the name: `shortener-view.blade.php`

Asset files will be placed in `resources/js/` and `resources/sass/` folders.

####TODO place image here
 
Besides files in resources folder there are two more files `shortener.js` and `shortener.css` that will be placed inside public folder:

####TODO place image here

These two files are based on resources folders `resources/js` and `resources/sass`
 
### 2nd step, you need to install npm dependencies in package.json file

```bash
npm install vue-template-compiler@2.6.10 clipboard@1.6.1 pluralize@4.0.0 vue@2.2.6 vue-axios@2.1.4 vue-router@2.3.1 vuex@2.3.1 --save-dev
```

### 3rd step, you need to add files to bundle in webpack.mix.js

```js
mix.js('resources/js/shortener.js', 'public/js/shortener.js')
    .sass('resources/sass/shortener.scss', 'public/css/shortener.css');
```

### 4th step, run the laravel mix, you can check package.json in `scripts` part for commands like

```bash
npm run dev
```
 
 or watcher
 
 ```bash
 npm run watch
 ```

## Usage


``` php
$skeleton = new MuhamedDidovic\Shortener();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

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

