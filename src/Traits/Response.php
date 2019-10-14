<?php

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
     * @return \Illuminate\Http\JsonResponse
     */
    protected function linkResponse(Link $link, $merge = [])
    {
        return response()->json([
            'data' => array_merge([
                'original_url' => $link->original_url,
                'shortened_url' => $link->shortenedUrl(),
                'code' => $link->code,
            ], $merge)
        ], 200);
    }
}