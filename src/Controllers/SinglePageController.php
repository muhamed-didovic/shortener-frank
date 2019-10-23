<?php

namespace MuhamedDidovic\Shortener\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Controller as BaseController;
use MuhamedDidovic\Shortener\Link;

/**
 * Class SinglePageController
 * @package MuhamedDidovic\Shortener\Controllers
 */
class SinglePageController extends BaseController
{
    /**
     * 
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
        if (!empty(request()->get('any'))) {
            return \Illuminate\Support\Facades\Redirect::to('/nope');
        }

        //return VUE spa app
        return view('shortener::frontend-test');
    }
}
