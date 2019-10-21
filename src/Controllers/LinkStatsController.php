<?php
declare(strict_types = 1);

namespace MuhamedDidovic\Shortener\Controllers;

use Cache;
use MuhamedDidovic\Shortener\Link;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use MuhamedDidovic\Shortener\Traits\Response;

/**
 * Class LinkStatsController
 * @package MuhamedDidovic\Shortener\Controllers
 */
class LinkStatsController extends BaseController
{
    use Response;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $code = $request->get('code');
        //todo: check cache
        $link = Cache::remember("stats.{$code}", 10, function () use ($code) {
            return Link::byCode($code)->first();
        });

        if ($link === null) {
            return response(null, 404);
        }

        return $this->linkResponse($link, [
            'requested_count' => (int)$link->requested_count,
            'used_count'      => (int)$link->used_count,
            'last_requested'  => $link->last_requested->toDateTimeString(),
            'last_used'       => $link->last_used ? $link->last_used->toDateTimeString() : null,
        ]);
    }
}
