<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::orderBy('id', 'DESC')->paginate(PAGINATE_COUNT);
        return view('dashboard.attributes.index', compact('attributes'));
    }


    public function create()
    {
        return view('dashboard.attributes.create');
    }

    public function store(AttributeRequest $request)
    {
        try {
            DB::beginTransaction();
            $attribute = Attribute::create([]);
            $attribute->name = $request->name;
            $attribute->save();

            DB::commit();
            return redirect()->route('admin.attributes')->with(['success' => 'تمت اضافة الخاصية بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.attributes')->with(['error' => 'فشل الاضافة']);
        }
    }


    public function edit($attribute_id)
    {
        $attribute = Attribute::find($attribute_id);
        if (!$attribute) {
            return redirect()->route('admin.attributes')->with(['error' => ' الخاصية غير موجودة']);
        }

        $attribute = Attribute::select('id')->find($attribute_id);
        return view('dashboard.attributes.edit', compact('attribute'));
    }

    public function update($attribute_id, AttributeRequest $request)
    {
        try {
            $attribute = Attribute::find($attribute_id);

            if (!$attribute) {
                return redirect()->route('admin.attributes')->with(['error' => ' الخاصية غير موجودة']);
            }

            $attribute->name = $request->name;
            $attribute->save();

            return redirect()->route('admin.attributes')->with(['success' => 'تم تحديث الخاصية بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.attributes')->with(['error' => 'فشل التحديث']);
        }
    }

    public function delete($attribute_id)
    {
        try {

            $attribute = Attribute::find($attribute_id);

            if (!$attribute) {
                return redirect()->route('admin.attributes')->with(['error' => ' الخاصية غير موجودة']);
            }

            $attribute->delete();

            return redirect()->route('admin.attributes')->with(['success' => 'تم حذف الخاصية بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.attributes')->with(['error' => 'فشل الحذف']);
        }
    }
}
