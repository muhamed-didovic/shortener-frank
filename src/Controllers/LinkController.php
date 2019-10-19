<?php
declare(strict_types = 1);

namespace MuhamedDidovic\Shortener\Controllers;

use Illuminate\Support\Facades\Validator;
use MuhamedDidovic\Shortener\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controller as BaseController;
use MuhamedDidovic\Shortener\Traits\Response;

/**
 * Class LinkController
 * @package MuhamedDidovic\Shortener\Controllers
 */
class LinkController extends BaseController
{
    use Response;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $code = $request->get('code');

        $link = Cache::rememberForever("link.{$code}", function () use ($code) {
            return Link::byCode($code)->first();
        });

        if ($link === null) {
            return response(null, 404);
        }

        $link->increment('used_count');

        $link->touchTimestamp('last_used');

        return $this->linkResponse($link);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'url' => [
                'required',
                'regex:#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i'
            ],
        ], [
            'url.required'   => 'Please enter a URL to shorten.',
            'url.regex' => 'Hmm, that doesn\'t look like a valid URL.',
        ]);

        $link = Link::firstOrNew([
            'original_url' => $request->get('url'),
        ]);

        if (!$link->exists) {
            $link->save();
        }

        $link->increment('requested_count');

        $link->touchTimestamp('last_requested');

        return $this->linkResponse($link);
    }
}
