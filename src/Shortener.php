<?php

declare(strict_types=1);

namespace MuhamedDidovic\Shortener;

/**
 * Class Math.
 */
class Shortener
{
    /**
     * @var string
     */
    private $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @param     $value
     * @param int $base
     * @return mixed|string
     */
    public function toBase($value, $base = 62)
    {
        $r = $value % $base;
        $result = $this->base[$r];
        $q = floor($value / $base);

        while ($q) {
            $r = $q % $base;
            $q = floor($q / $base);
            $result = $this->base[$r].$result;
        }

        return $result;
    }
}
