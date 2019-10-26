<?php

declare(strict_types=1);

namespace MuhamedDidovic\Shortener\Observers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use MuhamedDidovic\Shortener\Models\Link;
use MuhamedDidovic\Shortener\Exceptions\CodeGenerationException;

class LinkObserver
{
    /**
     * Handle the Link "created" event.
     *
     * @param Link $link
     * @return void
     * @throws CodeGenerationException
     */
    public function created(Link $link)
    {
        $link->update([
            'code'           => $link->getCode(),
            'last_requested' => Carbon::now(),
        ]);
    }

    /**
     * Handle the Link "updated" event.
     *
     * @param Link $link
     * @return void
     */
    public function updated(Link $link)
    {
        Cache::pull("link.{$link->code}");
        Cache::pull("stats.{$link->code}");
    }

    /**
     * Handle the Link "deleted" event.
     *
     * @param Link $link
     * @return void
     */
    public function deleted(Link $link)
    {
        Cache::pull("link.{$link->code}");
        Cache::pull("stats.{$link->code}");
    }
}
