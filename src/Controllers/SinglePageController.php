<?php

namespace MuhamedDidovic\Shortener\Controllers;

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
        //when we find code in db
        if (request()->segment(1) && $link = Link::whereCode(request()->segment(1))->first()) {
            //todo: what if original_url is null
            return \Illuminate\Support\Facades\Redirect::to($link->original_url, 301);
        }

        //when code is provided but not found
        if (! empty(request()->get('any'))) {
            return \Illuminate\Support\Facades\Redirect::to('/nope');
        }

        //return VUE spa app
        //todo - change name
        return view('shortener::shortener-view');
    }
}
