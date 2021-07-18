<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\SMSGateways\VictoryLinkSms;
use App\Http\Services\VerificationServices;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserVerificationCode;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public $verification_services;
    public $victory_link_sms;

    public function __construct(VerificationServices $verification_services, VictoryLinkSms $victory_link_sms)
    {
        $this->middleware('guest');
        $this->verification_services = $verification_services;
        $this->victory_link_sms = $victory_link_sms;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        try {

            DB::beginTransaction();
            $verification = [];
            $user = User::create([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'password' => Hash::make($data['password']),
            ]);

            // generate new code and save code in userVerificationcodes table
            $verification['user_id'] = $user->id;
            $verification_data = $this->verification_services->setVerificationCode($verification);
            $message = $this->verification_services->getSMSVerifyMessageByAppName($verification_data->code);


            // send code to user mobile by gateway (victory link sms) >> there are any gateway
            // note  there are no gateway credentails in config file
            // $this->victory_link_sms->sendSms($user->mobile, $message);

            Db::commit();
            return $user;
        } catch (\Exception $ex) {
            DB::rollBack();
        }
    }
}
