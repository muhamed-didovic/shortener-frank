<?php
declare(strict_types=1);

namespace MuhamedDidovic\Shortener;

use MuhamedDidovic\Shortener\Exceptions\CodeGenerationException;
use MuhamedDidovic\Shortener\Helpers\Math;
use MuhamedDidovic\Shortener\Traits\Eloquent\BindsDynamically;
use MuhamedDidovic\Shortener\Traits\Eloquent\TouchesTimestamps;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Link
 * @package MuhamedDidovic\Shortener
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
        'last_used'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'last_requested', 'last_used'
    ];

    /**
     * @return \Illuminate\Config\Repository|mixed|string
     */
    public function getTable()
    {
        return config('shortener.table');
    }

    /**
     * @return mixed|string
     * @throws CodeGenerationException
     */
    public function getCode()
    {
        if ($this->id === null) {
            throw new CodeGenerationException;
        }

        return (new Math)->toBase($this->id);
    }

    /**
     * @param $code
     * @return mixed
     */
    public static function byCode($code)
    {
        return static::where('code', $code);
    }

    /**
     * @return string|null
     */
    public function shortenedUrl()
    {
        if ($this->code === null) {
            return null;
        }

        //return env('CLIENT_URL') . '/' . $this->code;
        return config('shortener.url') . '/' . $this->code;
    }
}
