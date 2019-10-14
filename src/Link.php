<?php

namespace MuhamedDidovic\Shortener;

use MuhamedDidovic\Shortener\Exceptions\CodeGenerationException;
use MuhamedDidovic\Shortener\Helpers\Math;
use MuhamedDidovic\Shortener\Traits\Eloquent\TouchesTimestamps;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use TouchesTimestamps;

    protected $fillable = [
        'original_url',
        'code',
        'requested_count',
        'used_count',
        'last_requested',
        'last_used'
    ];

    protected $dates = [
        'last_requested', 'last_used'
    ];

    public function getCode()
    {
        if ($this->id === null) {
            throw new CodeGenerationException;
        }

        return (new Math)->toBase($this->id);
    }

    public static function byCode($code)
    {
        return static::where('code', $code);
    }

    public function shortenedUrl()
    {
        if ($this->code === null) {
            return null;
        }

        //return env('CLIENT_URL') . '/' . $this->code;
        return config('shortener.url') . '/' . $this->code;
    }
}
