<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;

class WishlistController extends Controller
{
    public function store()
    {
        // if (!auth()->user()->wishlist()->where('product_id', request('productId'))->exists()) {
        if (!auth()->user()->wishlistHas(request('productId'))) {
            auth()->user()->wishlist()->attach(request('productId'));
            return response()->json(['wished' => true]);
        }
    }

    public function delete()
    {
        auth()->user()->wishlist()->detach(request('productId'));
        return response()->json(['deleteFavorited' => true]);
    }


    public function index()
    {
        $products = auth()->user()->wishlist()->latest()->get();
        return view('front.wishlists', compact('products'));
    }
}
