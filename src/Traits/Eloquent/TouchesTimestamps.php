<?php

namespace MuhamedDidovic\Shortener\Traits\Eloquent;

trait TouchesTimestamps
{
    public function touchTimestamp($column)
    {
        $this->{$column} = $this->freshTimestamp();
        $this->save();
    }
}