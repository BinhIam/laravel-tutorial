<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 *
 */
class CachingController extends Controller
{

    /**
     * Demo for catching user page
     * @return View
     */
    public function index(): View
    {
        $user = User::all();
        return view('caching', compact('user'));
    }
}
