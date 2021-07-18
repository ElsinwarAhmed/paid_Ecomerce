<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerificationRequest;
use App\Http\Services\VerificationServices;

class VerificationCodeController extends Controller
{
    public $verifyCode;

    public function __construct(VerificationServices $verify)
    {
        $this->verifyCode = $verify;
    }

    public function getVerifyPage()
    {
        return view('auth.verification');
    }

    public function verify(VerificationRequest $request)
    {
        $check =  $this->verifyCode->checkOTPCode($request->code);

        if (!$check) {
            return redirect()->route('verify-page')->withErrors(['code' => 'الكود الذي ادخلته غير صحيح']);
        } else {
            $this->verifyCode->removeOTPCode($request->code);
            return redirect()->route('home');
        }
    }
}
