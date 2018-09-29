<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Mail\ActivationRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
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
        $user->firstName = $input['first'];
        $user->lastName = $input['last'];
        $user->telHome = $input['home'];
        $user->telMobile = $input['mobile'];
        $user->address = $input['address'];
        $user->xmasCardOK = $input['holiday_perm'];
        $user->promoMaterial = $input['promotion_perm'];
        $user->joinDate = Carbon::now()->timestamp;
        $user->activateAccKey = str_random(15);

        $user->setPasswordAttribute($input['password']);

        $user->save();

        $discount = Discount::create('WELCOME' . strtoupper($user->username));

        $discount->setActive(true)
                 ->setFlat(0)
                 ->setPercent(10)
                 ->setSingleUseOnly(false)
                 ->setValidFrom(Carbon::now()->format('Y-m-d'))
                 ->setValidTo(Carbon::now()->addMonths(12)->format('Y-m-d'))
                 ->save();

        Mail::to($user)
            ->send(new ActivationRequest($discount->validFrom, $discount->discountCode, $user->activateAccKey));

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
        if(!User::hasActivated($request->only('email'))) {
            throw new HttpException(403, 'Account has not been activated.');
        }

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
