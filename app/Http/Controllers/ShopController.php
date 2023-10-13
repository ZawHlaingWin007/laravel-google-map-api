<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::latest()->get();
        return response()->json([
            'shops' => $shops
        ]);
    }
    public function getNearByShops()
    {   
        $shops = Shop::latest()->get();
        return view('shop.index', compact('shops'));
    }

    public function getShopBySlug(Shop $shop)
    {
        return view('shop.show', compact('shop'));
    }
}
