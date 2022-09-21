<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        parent::__construct();
//        $this->middleware('guest')->except('logout');
//    }


    /**
     * @return mixed
     */
    public function loginWithGoogle(): mixed
    {
        return $this->authService->googleAuthenticate();
    }

    /**
     * @return mixed
     */
    public function loginWithGoogleCallBack(): mixed
    {
        return $this->authService->googleAuthenticateCallBack();
    }

    public function loginWithGitHub()
    {
        return $this->authService->githubAuthenticate();
    }

    /**
     * @return mixed
     */
    public function loginWithGitHubCallBack(): mixed
    {
        return $this->authService->githubAuthenticateCallBack();
    }

    /**
     * @return mixed
     */
    public function loginWithFaceBook(): mixed
    {
        return $this->authService->facebookAuthenticate();
    }

    /**
     * @return mixed
     */
    public function loginWithFaceBookCallBack(): mixed
    {
        return $this->authService->facebookAuthenticateCallBack();
    }
}
