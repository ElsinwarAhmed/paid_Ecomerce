<?php

namespace App\Http\Controllers\Site;

use App\Basket\Basket;
use App\Exceptions\QuantityExceededException;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    protected $basket, $id;

    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    public function index()
    {
        $basket = $this->basket;
        return view('front.cart.index', compact('basket'));
    }

    public function postAdd(Request $request)
    {
        $slug = $request->productSlug;
        $product = Product::where('slug', $slug)->firstOrFail();

        try {
            $this->basket->add($product, $request->quantity ?? 1);
        } catch (QuantityExceededException $e) {
            return 'Quantity Exceeded';  // must be trans as the site is multi languages
        }

        return 'Product added successfully to the card ';
    }

    public function postUpdate($slug, Request $request)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        try {
            $this->basket->update($product, $request->quantity);
        } catch (QuantityExceededException $ex) {
            return 'فشل التحديث';
        }

        if (!$request->quantity) {
            return array_merge([
                'total' => num_format($this->basket->subTotal()) . " (" . money('symbol') . " )"
            ], 'dddd');
        }
        return 'ssss';
    }
}
