<?php

namespace App\Services;

use App\User;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService extends BaseService
{
    /**
     * Authentication driver instance.
     *
     * @param \Tymon\JWTAuth\JWTAuth
     */
    private $auth;

    /**
     * AuthService constructor.
     *
     * @param \Tymon\JWTAuth\JWTAuth $auth
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Get the authenticated user.
     *
     * @return \Tymon\JWTAuth\Contracts\JWTSubject
     */
    public function user()
    {
        try {
            if (!$user = $this->auth->user()) {
                throw new NotFoundHttpException('User not found');
            }

            return $user;
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException(401, 'Invalid authorization token');
        }
    }

    /**
     * Authenticate a user against email and password.
     *
     * @param  array $credentials
     *
     * @return string
     */
    public function authenticate(array $credentials)
    {
        $this->validate($credentials, [
            'email' => 'required',
            'password' => 'required'
        ]);

        /**
         * Here we have to manually hash the password for old users to see if they are authenticated
         *
         * This can be skipped for newly registered users as they will get a newly hashed password
         */
        $password = sha1(config('app.old_secret') . $credentials['password']);

        $user = User::on()->where('email', $credentials['email'])
                    ->where('password', $password)
                    ->first();

        if (!is_null($user)) { // old user
            $token = $this->auth->fromUser($user);
        } else { // new user
            if (!$token = $this->auth->attempt($credentials)) {
                throw new UnauthorizedHttpException(401, 'Invalid credentials');
            }
        }

        return $token;
    }

    /**
     * Refresh an expired token.
     *
     * @return string
     */
    public function refresh()
    {
        try {
            if (!$refresh = $this->auth->refresh()) {
                throw new HttpException(500, 'Could not refresh token');
            }

            return $refresh;
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException(401, 'Invalid authorization token');
        }
    }

    /**
     * Invalidate a token.
     *
     * @return boolean
     */
    public function invalidate()
    {
        try {
            if (!$this->auth->parseToken()->invalidate(true)) {
                throw new HttpException(500, 'Could not invalidate token');
            }
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException(401, 'Invalid authorization token');
        }

        return true;
    }
}
