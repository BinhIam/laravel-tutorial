<?php namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

/**
 *
 */
class RedisCachingService
{

    /**
     * Setup our caching mechanism.
     *
     * @param $key
     * @param $minutes
     * @param $callback
     * @return mixed
     */
    public static function cachingForInstantTime($key, $minutes, $callback)
    {
        if ($value = Redis::get($key)) {
            return json_decode($value);
        }

        Redis::setex($key, $minutes, $value = $callback());

        return $value;
    }
}
