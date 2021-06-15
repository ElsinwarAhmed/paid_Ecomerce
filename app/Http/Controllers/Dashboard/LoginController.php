<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;

class LoginController extends Controller
{
    public function login()
    {
        return view('dashboard.auth.login');
    }

    public function postLogin(AdminLoginRequest $request)
    {
        // return $request;

        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
            // notify()->success('تم الدخول بنجاح  ');
            return redirect()->route('admin.dashboard');
        }
        // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
        return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);
    }

    public function logout()
    {
        $guard = $this->getGaurd();
        $guard->logout();
        return redirect()->route('admin.login');
    }

    public function getGaurd()
    {
        return auth('admin');
    }
}
