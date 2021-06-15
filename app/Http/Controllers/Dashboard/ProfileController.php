<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function editProfile()
    {
        $id = auth('admin')->user()->id;
        $admin = Admin::find($id);

        if (!$admin) {
            return redirect()->back()->with(['error' => 'هذا الادمن غير موجود']);
        }

        // return $admin;
        return view('dashboard.profile.edit', compact('admin'));
    }

    public function updateProfile(ProfileRequest $request, $id)
    {
        try {
            $admin = Admin::find($id);
            if (!$admin) {
                return redirect()->back()->with(['error' => 'هذا الادمن غير موجود']);
            }

            $data_request = $request->except(['id', 'password', 'password_confirmation']);

            if ($request->has('password')) {
                $data_request['password'] = bcrypt($request->password);
            }


            $admin->update($data_request);
            return redirect()->back()->with(['success' => 'تم تحديث الملف الشخصي بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'فشل التحديث']);
        }
    }
}
