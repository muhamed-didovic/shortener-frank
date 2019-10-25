<?php

namespace Tests\Middleware;

use Illuminate\Http\Request;
use MuhamedDidovic\Shortener\Test\TestCase;

class UrlMiddlewareTest extends TestCase
{
    public function urlsProvider()
    {
        return [
            ['google.com', 'http://google.com'],
            ['ftp://www.google.com', 'ftp://www.google.com'],
            ['http://www.google.com', 'http://www.google.com'],
            ['https://www.google.com', 'https://www.google.com'],
        ];
    }

    /**
     * @test
     * @dataProvider urlsProvider
     */
    public function http_is_prepended_to_url_and_not_prepended_to_url_if_scheme_exist($input, $expected)
    {
        $request = new Request;

        $request->replace([
            'url' => $input,
        ]);

        $middleware = new \MuhamedDidovic\Shortener\Middleware\ModifiesUrlRequestData;

        $middleware->handle($request, function ($req) use ($expected) {
            $this->assertEquals($expected, $req->url);
        });
    }
}
