<?php namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\App;
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


    /**
     * @return mixed|mixed[]
     */
    public function getViewFromRedis()
    {
        # Get all user from variable users.all from memcached redis instead of run query under
        if (Redis::exists('users.all')) {
            return json_decode(Redis::get('users.all'));
        }

        $users = User::all();
        # Set all user to variable users.all
        Redis::set('users.all', $users);

        # Set all user each 60 seconds
        #Redis::setex('users.all', 60, $users);

        return $users;
    }
}
