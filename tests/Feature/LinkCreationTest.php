<?php

namespace MuhamedDidovic\Shortener\Test\Feature;

use MuhamedDidovic\Shortener\Link;
use Carbon\Carbon;
use MuhamedDidovic\Shortener\Test\TestCase;

class LinkCreationTest extends TestCase
{

    /** @test */
    public function fails_if_no_url_given()
    {
        $response = $this->json('POST', config('shortener.routes.post_short_route'))
            ->assertJsonFragment(['url' => ['Please enter a URL to shorten.']])
            ->assertStatus(422);

        $this->assertDatabaseMissing(config('shortener.table'), [
            'code' => '1',
        ]);
    }

    /** @test */
    public function fails_if_url_is_invalid()
    {
        $response = $this->json('POST', config('shortener.routes.post_short_route'), [
            'url' => 'http://google^&$$^&*^',
        ])
            ->assertJsonFragment(['url' => ['Hmm, that doesn\'t look like a valid URL.']])
            ->assertStatus(422);

        $this->assertDatabaseMissing(config('shortener.table'), [
            'code' => '1',
        ]);
    }

    /** @test */
    public function link_without_scheme_can_be_shortened()
    {
        $this->json('POST', config('shortener.routes.post_short_route'), [
            'url' => 'www.google.com',
        ])
            ->assertJsonFragment([
                'data' => [
                    'original_url'  => 'http://www.google.com',
                    'shortened_url' => config('shortener.url') . '/1',
                    'code'          => '1',
                ],
            ])
            ->assertStatus(200);

        //"id" => "1"
        //"original_url" => "http://www.google.com"
        //"code" => null
        //"requested_count" => "1"
        //"used_count" => "0"
        //"created_at" => "2019-09-25 18:13:55"
        //"updated_at" => "2019-09-25 18:13:55"
        //"last_requested" => "2019-09-25 18:13:55"
        //"last_used" => null
        $this
            ->assertDatabaseHas(config('shortener.table'), [
                'original_url' => 'http://www.google.com',
                'code'         => '1',
            ]);
    }

    /** @test */
    public function link_with_scheme_can_be_shortened()
    {

        $this->json('POST', config('shortener.routes.post_short_route'),
            [
                'url' => 'http://www.google.com',
            ])
            ->assertJsonFragment([
                'data' => [
                    'original_url'  => 'http://www.google.com',
                    'shortened_url' => config('shortener.url') . '/1',
                    'code'          => '1',
                ],
            ])
            ->assertStatus(200);

        $this
            ->assertDatabaseHas(config('shortener.table'), [
                'original_url' => 'http://www.google.com',
                'code'         => '1',
            ]);
    }

    /** @test */
    public function link_is_only_shortened_once()
    {
        $url = 'http://www.google.com';

        $this->json('POST', config('shortener.routes.post_short_route'), ['url' => $url]);
        $this->json('POST', config('shortener.routes.post_short_route'), ['url' => $url]);

        $link = Link::where('original_url', $url)->get();

        $this->assertCount(1, $link);
    }

    /** @test */
    public function requested_count_is_incremented()
    {
        $url = 'http://www.google.com';

        $this->json('POST', config('shortener.routes.post_short_route'), ['url' => $url]);
        $this->json('POST', config('shortener.routes.post_short_route'), ['url' => $url]);

        $this->assertDatabaseHas(config('shortener.table'), [
            'original_url'    => $url,
            'requested_count' => 2,
        ]);
    }

    /** @test */
    public function last_requested_date_is_updated_for_existing_link()
    {
        Link::flushEventListeners();

        $today = Carbon::now();

        $link  = factory(Link::class)->create([
            'last_requested' => $today->subDays(2)->toDateTimeString(),
        ]);
       
        Carbon::setTestNow($today->addDays(2));

        $this->json('POST', config('shortener.routes.post_short_route'), ['url' => $link->original_url]);
        $this->assertDatabaseHas(config('shortener.table'), [
            'original_url'   => $link->original_url,
            'last_requested' => $today->toDateTimeString(),
        ]);

        // IMPORTANT: Reset the date to not affect the next test!
        Carbon::setTestNow();
    }
}
