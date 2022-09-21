<?php

namespace App\Http\Controllers;

use App\Services\RedisCommonService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Redis;

/**
 *
 */
class RedisController extends Controller
{

    /**
     * Redis get visitor
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View|Factory
     */
    public function index(): \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Contracts\View\View
    {
        $counter = $this->redis->visitCounters();
        return view('redis', compact('counter'));
    }


    /**
     * get list user from redis instead of run query ( Redis cache )
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function view()
    {
        return $this->redis->getViewFromRedis();
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Contracts\View\View
     */
    public function getVideo($id)
    {
        $video = $this->redis->getVideo($id);
        return view('redis', compact('video'));
    }

    /**
     * @param $id
     * @return Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View
     */
    public function downloadVideo($id)
    {
        $video = $this->redis->getVideo($id);
        $this->redis->downloadVideo($id);
        return view('redis', compact('video'));
    }
}
