<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;

class ProductController extends Controller
{
    public function productBySlug($slug)
    {
        $data = [];
        $data['product'] = Product::where('slug', $slug)->first();

        $product_id = $data['product']->id;  // get product id
        $product_categories_ids = $data['product']->categories->pluck('id');  //get category ids and in array


        $data['product_attributes'] = Attribute::whereHas('options', function ($q) use ($product_id) {
            $q->whereHas('product', function ($qq) use ($product_id) {
                $qq->where('product_id', $product_id);
            });
        })->get();

        $data['related_products'] = Product::whereHas('categories', function ($cat) use ($product_categories_ids) {
            $cat->whereIn('categories.id', $product_categories_ids);
        })->limit(20)->latest()->get();

        return view('front.products-details', $data);
    }
}
