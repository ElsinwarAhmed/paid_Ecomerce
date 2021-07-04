<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Http\Requests\OptionRequest;
use App\Models\Attribute;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::orderBy('id', 'DESC')->paginate(PAGINATE_COUNT);
        return view('dashboard.options.index', compact('options'));
    }


    public function create()
    {
        $products = Product::active()->select('id')->get();
        $attributes = Attribute::select('id')->get();
        return view('dashboard.options.create', compact('attributes', 'products'));
    }

    public function store(OptionRequest $request)
    {
        try {
            DB::beginTransaction();
            $options = Option::create($request->except(['_token']));
            $options->name = $request->name;
            $options->save();

            DB::commit();
            return redirect()->route('admin.options')->with(['success' => 'تمت اضافة القيمة بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.options')->with(['error' => 'فشل الاضافة']);
        }
    }


    public function edit($option_id)
    {
        $option = Option::find($option_id);
        if (!$option) {
            return redirect()->route('admin.options')->with(['error' => ' القيمة غير موجودة']);
        }

        $data = [];
        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();
        $data['option'] = Option::get()->find($option_id);
        return view('dashboard.options.edit', $data);
    }

    public function update($option_id, AttributeRequest $request)
    {
        try {
            $option = Option::find($option_id);

            if (!$option) {
                return redirect()->route('admin.options')->with(['error' => ' القيمة غير موجودة']);
            }
            $option->update($request->except(['_token', 'id']));
            $option->name = $request->name;
            $option->save();

            return redirect()->route('admin.options')->with(['success' => 'تم تحديث القيمة بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.options')->with(['error' => 'فشل التحديث']);
        }
    }

    public function delete($option_id)
    {
        try {

            $option = Option::find($option_id);

            if (!$option) {
                return redirect()->route('admin.options')->with(['error' => ' القيمة غير موجودة']);
            }
            $option->delete();

            return redirect()->route('admin.options')->with(['success' => 'تم حذف القيمة بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.brands')->with(['error' => 'فشل الحذف']);
        }
    }
}
