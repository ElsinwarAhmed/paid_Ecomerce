<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function editShippings($type)
    {

        if ($type === 'free') {
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();
        } elseif ($type === 'locale') {
            $shippingMethod = Setting::where('key', 'locale_label')->first();
        } elseif ($type === 'outer') {
            $shippingMethod = Setting::where('key', 'outer_label')->first();
        }
        return view('dashboard.settings.shippings.edit', compact('shippingMethod'));
    }

    public function updateShippings(ShippingRequest $request, $id)
    {
        try {

            $shippingMethod = Setting::find($id);
            // if (!$shippingMethod) {
            //     return redirect()->back()->with(['error' => 'طريقة الشحن غير موجودة']);
            // }

            DB::beginTransaction();
            $shippingMethod->update([
                'plan_value' => $request->plan_value,
            ]);

            $shippingMethod->value = $request->value;
            $shippingMethod->Save();

            DB::commit();
            return redirect()->back()->with(['success' => 'تم تحديث البيانات بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'فشل تحديث البيانات']);
            DB::rollBack();
        }
    }
}
