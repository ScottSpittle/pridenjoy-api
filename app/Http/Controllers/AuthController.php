<?php

namespace App\Http\Controllers;

use App\User;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    /**
     * Auth Service.
     *
     * @var \App\Services\AuthService
     */
    private $auth;

    /**
     * AuthController constructor.
     *
     * @param \App\Services\AuthService $auth
     */
    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws HttpException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'username' => 'required|string',
            'first' => 'required|string',
            'last' => 'required|string',
            'home' => 'required|string',
            'mobile' => 'required|string',
            'address' => 'required|string',
            'holiday_perm' => 'required|boolean',
            'promotion_perm' => 'required|boolean',
        ]);

        $input = $request->input();

        $existingUserCount = User::on()->where('email', $input['email'])->count();

        if ($existingUserCount > 0) {
            throw new HttpException(409, 'User already exists with this email address');
        }

        $user = new User();

        $user->email = $input['email'];
        $user->username = $input['username'];
        $user->first = $input['first'];
        $user->last = $input['last'];
        $user->home = $input['home'];
        $user->mobile = $input['mobile'];
        $user->address = $input['address'];
        $user->holiday_perm = $input['holiday_perm'];
        $user->promotion_perm = $input['promotion_perm'];

        $user->setPasswordAttribute($input['password']);

        $user->save();

        return response()->json($user);
    }

    /**
     * Authenticate a user against email and password.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $token = $this->auth->authenticate($request->only('email', 'password'));

        return response()->json(compact('token'));
    }

    /**
     * Refresh an expired token.
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        $token = $this->auth->refresh();

        return response()->json(compact('token'));
    }

    /**
     * Invalidate a token.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $this->auth->invalidate();

        return response(null, 204);
    }

    /**
     * Get the current authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function currentUser()
    {
        $user = $this->auth->user();

        return response()->json($user);
    }
}
