<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\CategoryRequest;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(PAGINATE_COUNT);
        return view('dashboard.brands.index', compact('brands'));
    }


    public function create()
    {
        return view('dashboard.brands.create');
    }

    public function store(BrandRequest $request)
    {
        try {
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }

            $data_request = $request->except(['photo', '_token']);

            if ($request->has('photo')) {
                $file_name = saveImage($request->photo, 'images/brands');
                $data_request['photo'] = $file_name;
            }


            DB::beginTransaction();
            $brand = Brand::create($data_request);
            $brand->name = $request->name;
            $brand->save();


            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تمت اضافة الماركة التجارية بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error' => 'فشل الاضافة']);
        }
    }


    public function edit($brand_id)
    {
        $brand = Brand::find($brand_id);
        if (!$brand) {
            return redirect()->route('admin.brands')->with(['error' => ' الماركة التجارية غير موجودة']);
        }

        $brand = Brand::get()->find($brand_id);
        return view('dashboard.brands.edit', compact('brand'));
    }

    public function update($brand_id, BrandRequest $request)
    {
        try {
            $brand = Brand::find($brand_id);

            if (!$brand) {
                return redirect()->route('admin.categories')->with(['error' => ' الماركة التجارية غير موجودة']);
            }

            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }

            $data_request = $request->except(['_token', 'photo']);

            if ($request->has('photo')) {
                $photo = Str::after($brand->photo, '8000/');
                unlink($photo);
                $file_name = saveImage($request->photo, 'images/brands');
                $data_request['photo'] = $file_name;
            }

            DB::beginTransaction();
            $brand->update($data_request);

            $brand->name = $request->name;
            $brand->save();


            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم تحديث الماركة التجارية بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error' => 'فشل التحديث']);
        }
    }

    public function delete($brand_id)
    {
        try {

            $brand = Brand::find($brand_id);

            if (!$brand) {
                return redirect()->route('admin.brands')->with(['error' => ' الماركة التجارية غير موجودة']);
            }

            $photo = Str::after($brand->photo, '8000/');
            unlink($photo);


            $brand->delete();

            return redirect()->route('admin.brands')->with(['success' => 'تم حذف الماركة التجارية بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.brands')->with(['error' => 'فشل الحذف']);
        }
    }
}
