<?php

namespace MuhamedDidovic\Shortener\Middleware;

use Illuminate\Support\Facades\Validator;
use Closure;

class ModifiesUrlRequestData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has('url')) {
            return $next($request);
        }

//        $validator = Validator::make($request->all(), [
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);
//
//        if ($validator->fails()) {
//            return redirect('post/create')
//                ->withErrors($validator)
//                ->withInput();
//        }

        $validator = Validator::make($request->only('url'), [
            'url' => 'active_url'
        ]);

        if ($validator->fails()) {
            $request->merge([
                'url' => 'http://' . $request->url
            ]);
        }

        return $next($request);
    }
}
