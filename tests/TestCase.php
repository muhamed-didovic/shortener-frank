<?php

namespace MuhamedDidovic\Shortener\Test;

use MuhamedDidovic\Shortener\Link;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MuhamedDidovic\Shortener\ShortenerServiceProvider;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withFactories(__DIR__.'/database/factories');
        $this->artisan('migrate', ['--database' => 'testing']);
    }

    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ShortenerServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Get package aliases.  In a normal app environment these would be added to
     * the 'aliases' array in the config/app.php file.  If your package exposes an
     * aliased facade, you should add the alias here, along with aliases for
     * facades upon which your package depends, e.g. Cartalyst/Sentry.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    //    protected function getPackageAliases($app)
    //    {
    //        return [
    //            //'YourPackage' => 'YourProject\YourPackage\Facades\YourPackage',
    //        ];
    //    }

    /** @test */
    public function it_runs_the_migrations()
    {
        $link = factory(Link::class)->create();

        $users = \DB::table(config('shortener.table'))->where('id', '=', 1)->first();
        $this->assertEquals('1', $link->code);
        $this->assertEquals([
            'id',
            'original_url',
            'code',
            'requested_count',
            'used_count',
            'last_requested',
            'last_used',
            'created_at',
            'updated_at',
        ], \Schema::getColumnListing(config('shortener.table')));
    }

    /** @test */
    public function it_runs_the_migrations_with_flush_event_listeners()
    {
        Link::flushEventListeners();
        $link = factory(Link::class)->create([
            'code' => 'abc',
        ]);

        $users = \DB::table(config('shortener.table'))->where('id', '=', 1)->first();
        $this->assertEquals('abc', $link->code);
        $this->assertEquals([
            'id',
            'original_url',
            'code',
            'requested_count',
            'used_count',
            'last_requested',
            'last_used',
            'created_at',
            'updated_at',
        ], \Schema::getColumnListing(config('shortener.table')));
    }
}
