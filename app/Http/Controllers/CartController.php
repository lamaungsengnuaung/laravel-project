<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // direct my cart list
    public function mycart()
    {
        $carts = Cart::where('user_id', Auth::user()->id)
            ->select('*', 'carts.id as cart_id')
            ->leftJoin('products', 'carts.product_id', 'products.id')
            ->get();
        $totalprice = 0;
        foreach ($carts as $cart) {
            $totalprice += $cart->price * $cart->qty;
        }
        // dd($totalprice);
        // dd($carts->toArray());
        return view('user.main.cart', compact(['carts', 'totalprice']));
    }
}
