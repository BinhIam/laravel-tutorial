<?php namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 *
 */
class CachingService
{

    /**
     * A list of model cache keys.
     *
     * @param array $keys
     */
    protected static $keys = [];

    /**
     * Setup our caching mechanism.
     *
     * @param mixed $model
     */
    public static function setUp($model)
    {
        static::$keys[] = $key = $model->getCacheKey();

        ob_start();

        return Cache::has($key);
    }


    /**
     * @return void
     */
    public static function down()
    {
        // Fetch the cache key
        $key = array_pop(static::$keys);

        // Save the output buffer contents into variables
        $html = ob_get_clean();

        // Caching, echo the data stored
        return Cache::rememberForever($key, function () use ($html) {
            return $html;
        });
    }

}
