<?php

namespace MuhamedDidovic\Shortener\Test\Feature;

use MuhamedDidovic\Shortener\Models\Link;
use MuhamedDidovic\Shortener\Test\TestCase;

class LinkStatsTest extends TestCase
{
    /** @test */
    public function link_stats_can_be_shown_by_shortened_code()
    {
        $link = factory(Link::class)->create([
            'requested_count' => 5,
            'used_count'      => 234,
        ]);

        $this
            ->json('GET', config('shortener.routes.get_stats_route'), [
                'code' => $link->code,
            ])
           ->assertJsonFragment($this->expectedJson($link));
    }

    /** @test */
    public function link_stats_fails_if_not_found()
    {
        $this
            ->json('GET', config('shortener.routes.get_stats_route'), ['code' => 'abc'])
            ->assertStatus(404);
    }

    protected function expectedJson(Link $link)
    {
        return [
            'original_url'    => $link->original_url,
            'shortened_url'   => $link->shortenedUrl(),
            'code'            => $link->code,
            'requested_count' => $link->requested_count,
            'used_count'      => $link->used_count,
            'last_requested'  => is_object($link->last_requested) ? $link->last_requested->toDateTimeString() : $link->last_requested->toDateTimeString(),
            'last_used'       => $link->last_used ? $link->last_used : null,
        ];
    }
}
