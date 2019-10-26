<?php

namespace MuhamedDidovic\Shortener\Controllers;

use Illuminate\Support\Facades\Cache;
use MuhamedDidovic\Shortener\Models\Link;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class SinglePageController.
 */
class SinglePageController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show()
    {
        //when code is found in DB
        if ($code = request()->segment(1)) {
            $link = Cache::rememberForever("link.{$code}", function () use ($code) {
                return Link::byCode($code)->first();
            });

            if ($link) {
                $link->increment('used_count');
                $link->touchTimestamp('last_used');

                return \Illuminate\Support\Facades\Redirect::to($link->original_url, 301);
            }

            return \Illuminate\Support\Facades\Redirect::to('/nope');
        }

        //when code is provided but not found
        //        if (!empty(request()->segment(1))) {
        //            return \Illuminate\Support\Facades\Redirect::to('/nope');
        //        }

        //return VUE spa app
        return view('shortener::shortener-view');
    }
}
