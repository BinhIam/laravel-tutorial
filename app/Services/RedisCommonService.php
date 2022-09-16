<?php namespace App\Services;

use Illuminate\Support\Facades\Redis;

/**
 *
 */
class RedisCommonService
{

    /**
     * Counter the number of user visit
     *
     * @return mixed
     */
    public static function visitCounters()
    {
        return Redis::incr('visits');
    }

    /**
     * get Video by Id
     *
     * @return mixed
     */
    public static function getVideo($id)
    {
        return Redis::get("video.{$id}.downloads");
    }

    /**
     * Download video
     *
     * @return mixed
     */
    public static function downloadVideo($id)
    {
        return Redis::incr("video.{$id}.downloads");
    }
}
