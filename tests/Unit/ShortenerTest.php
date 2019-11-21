<?php

namespace MuhamedDidovic\Shortener\Test\Unit;

use MuhamedDidovic\Shortener\Facades\Shortener;
use MuhamedDidovic\Shortener\Test\TestCase;

class ShortenerTest extends TestCase
{
    public function mappingsProvider()
    {
        return [
            [1, 1],
            [100, '1C'],
            [1000000, '4c92'],
            [999999999, '15FTGf'],
        ];
    }

    /**
     * @test
     * @dataProvider mappingsProvider
     */
    public function correctly_encodes_values($input, $expected)
    {
        $this->assertEquals($expected, Shortener::toBase($input));
    }
}
