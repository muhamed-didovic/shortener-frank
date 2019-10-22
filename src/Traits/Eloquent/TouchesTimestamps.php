<?php

namespace MuhamedDidovic\Shortener\Traits\Eloquent;

/**
 * Trait TouchesTimestamps
 * @package MuhamedDidovic\Shortener\Traits\Eloquent
 */
trait TouchesTimestamps
{
    /**
     * @param $column
     */
    public function touchTimestamp($column)
    {
        $this->{$column} = $this->freshTimestamp();
        $this->save();
    }
}
