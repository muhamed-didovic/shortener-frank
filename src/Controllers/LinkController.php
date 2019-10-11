<?php

namespace MuhamedDidovic\Shortener\Controllers;

use MuhamedDidovic\Shortener\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controller as BaseController;

class LinkController extends BaseController
{
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

    public function store(Request $request)
    {
        $this->validate($request, [
//            'url' => 'required|url',
            'url' => 'required|active_url'
        ], [
            'url.required' => 'Please enter a URL to shorten.',
            'url.active_url' => 'Hmm, that doesn\'t look like a valid URL.'
//            'url.url' => 'Hmm, that doesn\'t look like a valid URL.'
        ]);

        $link = Link::firstOrNew([
            'original_url' => $request->get('url')
        ]);

        if (!$link->exists) {
            $link->save();
        }

        $link->increment('requested_count');

        $link->touchTimestamp('last_requested');

        return $this->linkResponse($link);
    }
}
