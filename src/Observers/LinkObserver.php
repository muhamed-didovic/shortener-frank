<?php

declare(strict_types=1);

namespace MuhamedDidovic\Shortener\Observers;

use Carbon\Carbon;
use MuhamedDidovic\Shortener\Models\Link;
use MuhamedDidovic\Shortener\Exceptions\CodeGenerationException;

class LinkObserver
{
    /**
     * Handle the User "created" event.
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
}
