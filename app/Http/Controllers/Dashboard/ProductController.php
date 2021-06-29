<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategorType;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\GeneralProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        // $categories = Category::orderBy('id', 'DESC')->paginate(PAGINATW_COUNT);
        // return view('dashboard.categories.index', compact('categories'));
    }


    public function create()
    {

        $data = [];
        $data['brands'] = Brand::isactive()->select('id')->get();
        $data['tags'] = Tag::select('id')->get();
        $data['categories'] = Category::isactive()->select('id')->get();

        return view('dashboard.products.general.create', $data);
    }

    public function store(GeneralProductRequest $request)
    {

        try {
            // if (!$request->has('is_active')) {
            //     $request->request->add(['is_active' => 0]);
            // } else {
            //     $request->request->add(['is_active' => 1]);
            // }

            // DB::beginTransaction();
            // $product = Product::create($request->except('_token'));
            // $product->categories->attch()->$request->categories;
            // $product->name = $request->name;
            // $product->description = $request->description;
            // $product->short_description = $request->short_description;
            // $product->save();


            // DB::commit();
            // return redirect()->route('admin.categories')->with(['success' => 'تمت اضافة القسم بنجاح']);
        } catch (\Exception $ex) {
            // DB::rollBack();
            return redirect()->route('admin.categories')->with(['error' => 'فشل الاضافة']);
        }
    }


    public function edit($cat_id)
    {
        $category = Category::find($cat_id);
        if (!$category) {
            return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);
        }

        $categories = Category::select('id', 'parent_id')->get();
        $category = Category::get()->find($cat_id);
        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    public function update($cat_id, CategoryRequest $request)
    {
        try {
            $category = Category::find($cat_id);

            if (!$category) {
                return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);
            }

            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }

            if ($request->type == 1) {
                $request->request->add(['parent_id' => null]);
            }

            DB::beginTransaction();
            $category->update($request->all());

            $category->name = $request->name;
            $category->save();


            DB::commit();
            return redirect()->route('admin.categories')->with(['success' => 'تم تحديث القسم بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.categories')->with(['error' => 'فشل التحديث']);
        }
    }

    public function delete($cat_id)
    {
        try {

            $category = Category::find($cat_id);

            if (!$category) {
                return redirect()->route('admin.categories')->with(['error' => 'هذا القسم غير موجود']);
            }

            $category->delete();

            return redirect()->route('admin.categories')->with(['success' => 'تم حذف القسم بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.categories')->with(['error' => 'فشل الحذف']);
        }
    }
}
