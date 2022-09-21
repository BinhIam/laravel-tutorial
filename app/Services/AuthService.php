<?php namespace App\Services;

use App\Events\UserRegistered;
use App\Helpers\ResponseHelper;
use App\Listeners\UserRegisterd;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

/**
 *
 */
class AuthService
{
    /**
     * The user repository.
     *
     */
    public UserRepository|Model $userRepository;

    /**
     * The response helper.
     *
     */
    public ResponseHelper $responseHelper;

    /**
     * Service google
     *
     */
    public mixed $google;

    /**
     * Service gitHub
     *
     */
    public mixed $github;

    /**
     * Service facebook
     *
     */
    public mixed $facebook;

    /**
     * @param UserRepository $userRepository
     * @param ResponseHelper $responseHelper
     */
    public function __construct(
        UserRepository $userRepository,
        ResponseHelper $responseHelper
    ){
        $this->userRepository = $userRepository;
        $this->responseHelper = $responseHelper;
        $this->google = config('GOOGLE') ?? 'google';
        $this->github = config('GIT_HUB') ?? 'github';
        $this->facebook = config('FACEBOOK') ?? 'facebook';
    }

    /**
     * @description Register for user
     *
     * @param $request
     * @return JsonResponse
     * @var Model
     */
    public function register($request): JsonResponse
    {
        // Create new user instantly
        $user = $this->userRepository->createUser([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);
        event(new UserRegistered);
        if (!$user->exists) {
            return $this->responseHelper->responseFail();
        }
        return $this->responseHelper->responseSuccess(['user' => $user]);
    }

    /**
     * @description Login for user
     *
     * @param $request
     * @return JsonResponse
     * @var Model
     */
    public function login($request): JsonResponse
    {
        // Accept only email, password
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return $this->responseHelper->responseFail();
        }
        // Find user by email
        $user = $this->userRepository->findByEmail($request->get('email'));
        if (!Hash::check($request->get('password'), $user->password)) {
            return $this->responseHelper->responseNotFound();
        }
        // Generate current token for using other api
        $tokenResult = $user->createToken('authToken')->plainTextToken;
        return $this->responseHelper->responseSuccess([
            'access_token' => $tokenResult,
            'user' => $user
        ]);
    }

    /**
     * @description Logout for user
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        // Revoke all tokens
        auth()->user()->tokens()->delete();
        return $this->responseHelper->responseSuccess();
    }

    /**
     * Login with Google
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
     */
    public function googleAuthenticate(): RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
    {
        return $this->oAuth2($this->google);
    }

    /**
     * Login with Github
     *
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function githubAuthenticate(): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        return $this->oAuth2($this->github);
    }

    /**
     * Login with Facebook
     *
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function facebookAuthenticate(): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        return $this->oAuth2($this->facebook);
    }

    /**
     * Login with Google Callback
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function googleAuthenticateCallBack(): Application|RedirectResponse|Redirector
    {
        return $this->oAuth2CallBack($this->google);
    }

    /**
     * Login with GitHub Callback
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function githubAuthenticateCallBack(): Redirector|RedirectResponse|Application
    {
        return $this->oAuth2CallBack($this->github);
    }

    /**
     * Login with Facebook Callback
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function facebookAuthenticateCallBack(): Redirector|RedirectResponse|Application
    {
        return $this->oAuth2CallBack($this->facebook);
    }


    /**
     * @param $service
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
     */
    public function oAuth2($service): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        return Socialite::driver($service)->redirect();
    }

    /**
     * @param $service
     * @return
     */
    public function oAuth2CallBack($service): Redirector|Application|RedirectResponse
    {
        $user = Socialite::driver($service)->stateless()->user();
        $existUser = $this->userRepository->findByEmail($user->email);
        if ($existUser) {
            Auth::Login($existUser, true);
        } else {
            $newUser = $this->userRepository->createUser([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ]);
            Auth::Login($newUser, true);
        }
        return redirect('/');

//        $user = User::updateOrCreate([
//            'github_id' => $githubUser->id,
//        ], [
//            'name' => $githubUser->name,
//            'email' => $githubUser->email,
//            'github_token' => $githubUser->token,
//            'github_refresh_token' => $githubUser->refreshToken,
//        ]);
    }
}

