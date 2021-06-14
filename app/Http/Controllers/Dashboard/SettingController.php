<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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

    public function updateShippings(Request $request, $id)
    {
        return $request;
    }
}
