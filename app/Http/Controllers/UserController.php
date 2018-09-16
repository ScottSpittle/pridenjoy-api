<?php

namespace App\Http\Controllers;

use App\User;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use App\Services\AuthService;

class UserController extends Controller
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
    public function updatePersonal(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'first' => 'required|string',
            'last' => 'required|string',
            'home' => 'required|string',
            'mobile' => 'required|string',
            'address' => 'required|string'
        ]);

        $input = $request->input();

        $user = $this->auth->user();

        $this->checkUsername($user, $input['username']);

        $user->username = $input['username'];
        $user->firstName = $input['first'];
        $user->lastName = $input['last'];
        $user->telHome = $input['home'];
        $user->telMobile = $input['mobile'];
        $user->address = $input['address'];

        $user->save();

        return response()->json($user);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws HttpException
     */
    public function updateEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|confirmed'
        ]);

        $input = $request->input();
        $user = $this->auth->user();

        $this->checkEmail($user, $input['email']);

        $user->email = $input['email'];
        $user->save();

        return response()->json($user);
    }

    /**
     * @param User   $user
     * @param string $username
     */
    private function checkUsername(User $user, $username)
    {
        if($user->username === $username) {
            return;
        }

        $existingUserCount = User::on()->where('username', $username)->count();

        if ($existingUserCount > 0) {
            throw new HttpException(409, 'User already exists with this username');
        }
    }

    /**
     * @param User $user
     * @param      $email
     */
    private function checkEmail(User $user, $email)
    {
        if($user->email === $email) {
            return;
        }

        $existingUserCount = User::on()->where('email', $email)->count();

        if ($existingUserCount > 0) {
            throw new HttpException(409, 'User already exists with this email address');
        }
    }
}
