<?php

namespace MuhamedDidovic\Shortener\Test\Unit;

use MuhamedDidovic\Shortener\Test\TestCase;

class MathTest extends TestCase
{
    protected $mappings = [
        1 => 1,
        100 => '1C',
        1000000 => '4c92',
        999999999 => '15FTGf',
    ];

    /** @test */
    public function correctly_encodes_values()
    {
        $math = new \MuhamedDidovic\Shortener\Helpers\Math;

        foreach ($this->mappings as $value => $encoded) {
            $this->assertEquals($encoded, $math->toBase($value));
        }
    }
}
