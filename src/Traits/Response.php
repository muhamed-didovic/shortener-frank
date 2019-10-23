<?php
declare(strict_types = 1);

namespace MuhamedDidovic\Shortener\Traits;

use MuhamedDidovic\Shortener\Link;

/**
 * Trait Response
 * @package MuhamedDidovic\Shortener\Traits
 */
trait Response
{
    /**
     * @param Link  $link
     * @param array $merge
     * @return \Illuminate\Http\Response
     */
    protected function linkResponse(Link $link, $merge = [])
    {
        return response()->json([
            'data' => array_merge([
                'original_url'   => $link->original_url,
                'shortened_url'  => $link->shortenedUrl(),
                'code'           => $link->code,
                'last_requested' => $link->last_requested,
                'last_used'      => $link->last_used ?? null,
            ], $merge),
        ], 200);
    }
}
