<?php

namespace MuhamedDidovic\Shortener\Test\Feature;

use Illuminate\Support\Facades\Artisan;
use MuhamedDidovic\Shortener\Models\Link;
use MuhamedDidovic\Shortener\Test\TestCase;

class ShortenerCommandTest extends TestCase
{
    /** @test */
    public function the_console_command_returns_found_null_values()
    {
        Link::flushEventListeners();
        $this->withoutMockingConsoleOutput();

        factory(Link::class)->create();
        factory(Link::class)->create();
        factory(Link::class)->create([
            'code' => 'abc',
        ]);

        $this->artisan('shortener:clean');
        $output = Artisan::output();

        $this->assertSame('Deleted rows:2'.PHP_EOL, $output);
    }

    /** @test */
    public function the_console_command_returns_not_found_null_values()
    {
        $this->withoutMockingConsoleOutput();

        factory(Link::class)->create();
        factory(Link::class)->create();

        $this->artisan('shortener:clean');
        $output = Artisan::output();

        $this->assertSame('Deleted rows:0'.PHP_EOL, $output);
    }
}
