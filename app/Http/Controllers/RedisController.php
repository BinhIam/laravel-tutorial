<?php

namespace App\Http\Controllers;

use App\Services\RedisCommonService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;

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
