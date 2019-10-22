<?php

namespace MuhamedDidovic\Shortener\Test\Feature;

use MuhamedDidovic\Shortener\Link;
use Carbon\Carbon;
use MuhamedDidovic\Shortener\Test\TestCase;

class LinkShowTest extends TestCase
{

    /** @test */
    public function requested_link_details_are_returned()
    {
        $link = factory(Link::class)->create();

        $response = $this->json('GET', config('shortener.routes.post_short_route'),
            [
                'code' => $link->code,
            ])
            ->assertJsonFragment([
                'original_url'  => $link->original_url,
                'shortened_url' => $link->shortenedUrl(),
                'code'          => $link->code,
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function throws_404_if_no_link_found()
    {
        $response = $this->json('GET', config('shortener.routes.post_short_route'), ['code' => 'abc']);

        $response->assertStatus(404);
        $this->assertEmpty($response->getContent());
    }

    /** @test */
    public function used_count_is_incremented()
    {
        $link = factory(Link::class)->create();

        $this->json('GET', config('shortener.routes.post_short_route'), ['code' => $link->code]);
        $this->json('GET', config('shortener.routes.post_short_route'), ['code' => $link->code]);
        $this->json('GET', config('shortener.routes.post_short_route'), ['code' => $link->code]);

        $this->assertDatabaseHas(config('shortener.table'), [
            'original_url' => $link->original_url,
            'used_count'   => 3,
        ]);
    }

    /** @test */
    public function last_used_date_is_updated()
    {
        Link::flushEventListeners();

        $link = factory(Link::class)->create([
            'last_used' => Carbon::now()->subDays(2)->toDateTimeString(),
        ]);

        $reponse = $this->json('GET', config('shortener.routes.get_short_route'), ['code' => $link->code]);
        $json = json_decode($reponse->getContent());

        $lastUsed = is_object($json->data->last_used) ? $json->data->last_used->date : $json->data->last_used;
        $this->assertDatabaseHas(config('shortener.table'), [
            'original_url' => $link->original_url,
            'last_used'    => Carbon::parse($lastUsed)->toDateTimeString(),
        ]);

        $this->assertNotEquals(Carbon::parse($lastUsed)->toDateTimeString(), $link->last_used);
        $this->assertTrue(Carbon::parse($lastUsed)->notEqualTo($link->last_used));
    }
}
