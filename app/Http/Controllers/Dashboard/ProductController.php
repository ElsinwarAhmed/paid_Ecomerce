<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategorType;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\InventoryProductRequest;
use App\Http\Requests\PriceProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::select('id', 'price', 'slug', 'created_at')->paginate(PAGINATE_COUNT);
        return view('dashboard.products.general.index', compact('products'));
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
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }

            DB::beginTransaction();
            $product = Product::create($request->except('_token'));
            $product->categories()->attach($request->categories);
            $product->tags()->attach($request->tags);

            $product->name = $request->name;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->save();

            DB::commit();
            return redirect()->route('admin.products')->with(['success' => 'تمت اضافة القسم بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.products')->with(['error' => 'فشل الاضافة']);
        }
    }

    // ======== update price =======

    public function getPrice($product_id)
    {
        return view('dashboard.products.price.create', compact('product_id'));
    }

    public function storePrice(PriceProductRequest $request)
    {
        try {

            Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));

            return redirect()->route('admin.products')->with(['success' => 'تم تحديث السعر  بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.products')->with(['error' => 'فشل تحديث السعر']);
        }
    }


    // ======== update inventory =======
    public function getInventory($product_id)
    {
        $product = Product::find($product_id);
        return view('dashboard.products.inventory.create', compact('product_id', 'product'));
    }

    public function storeInventory(InventoryProductRequest $request)
    {
        try {
            Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));
            return redirect()->route('admin.products')->with(['success' => 'تم تحديث المخزون  بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.products')->with(['error' => 'فشل تحديث المخزون']);
        }
    }


    // ======== update images =======
    public function getImages($product_id)
    {
        return view('dashboard.products.images.create', compact('product_id'));
    }


    // save image in folder only
    public function storeImages(Request $request)
    {
        $file = $request->file('dzfile');
        $filename = saveImage($file, 'images\products');

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function storeImagesDB(ImageRequest $request)
    {
        try {
            if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Image::create([
                        'product_id' => $request->product_id,
                        'photo' => $image,
                    ]);
                }
            }
            return redirect()->route('admin.products')->with(['success' => 'تم اضافة صور المنتج  بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.products')->with(['error' => 'فشل اضافة الصور']);
        }
    }
}
