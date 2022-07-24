<?php

namespace App\Http\Controllers\Auth;

use App\Enums\ReferralStatus;
use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\UnclaimedReferralCode;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data,
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'referral_code' => ['sometimes', new UnclaimedReferralCode]
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if(request()->has('referral_code')) {
            $referral = Referral::where('code', request()->input('referral_code'))->first();
            (new ReferralService())->claimReferral($referral);
        }

        return $user;
    }

    // Custom Register form
    public function showRegistrationForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['sometimes', new UnclaimedReferralCode]
        ]);

        if($validator->fails()) {
            // Refresh register page but without `code` query param
            $request->session()->flash('invalid_code', 'Invalid referral code.');
            return redirect()->route('register');
        }

        return view('auth.register');
    }
}
