<?php

declare(strict_types=1);

namespace MuhamedDidovic\Shortener\Models;

use Illuminate\Database\Eloquent\Model;
use MuhamedDidovic\Shortener\Exceptions\CodeGenerationException;
use MuhamedDidovic\Shortener\Facades\Shortener;
use MuhamedDidovic\Shortener\Traits\Eloquent\TouchesTimestamps;

/**
 * Class Link.
 */
class Link extends Model
{
    use TouchesTimestamps;

    /**
     * @var array
     */
    protected $fillable = [
        'original_url',
        'code',
        'requested_count',
        'used_count',
        'last_requested',
        'last_used',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'last_requested',
        'last_used',
    ];

    /**
     * Override or change name of the table from config file
     * @return \Illuminate\Config\Repository|mixed|string
     */
    public function getTable()
    {
        return config('shortener.table');
    }

    /**
     * Get the code from the ID of table
     * @return mixed|string
     * @throws CodeGenerationException
     */
    public function getCode()
    {
        if ($this->id === null) {
            throw new CodeGenerationException;
        }

        return Shortener::toBase($this->id);
    }

    /**
     * Get resource by code
     * @param $code
     * @return mixed
     */
    public static function byCode($code)
    {
        return static::where('code', $code);
    }

    /**
     * Get full new shortened URL with code
     * @return string|null
     */
    public function shortenedUrl()
    {
        if ($this->code === null) {
            return;
        }

        return config('shortener.url').'/'.$this->code;
    }
}
