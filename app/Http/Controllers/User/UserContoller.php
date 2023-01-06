<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use Mockery\Undefined;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserContoller extends Controller
{
    //direct home
    public function home()
    {
        $product = Product::get();
        $category = Category::get();
        $cartCount = Cart::where('user_id', Auth::user()->id)->get();
        $orderCount = Order::where('user_id', Auth::user()->id)->get();
        // $product->appends(request()->all());
        return view('user.main.home', compact(['category', 'product', 'cartCount', 'orderCount']));
    }

    // filter by category
    public function filter($id)
    {
        $product = Product::where('category_id', $id)->orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cartCount = Cart::where('user_id', Auth::user()->id)->get();
        $orderCount = Order::where('user_id', Auth::user()->id)->get();

        // dd(count($product));
        // dd($id, $product, $category);
        return view('user.main.home', compact(['category', 'product', 'cartCount', 'orderCount']));
    }
    // pizza detail
    public function detail($id)
    {
        $pizza = Product::where('id', $id)->first();
        $product = Product::Select('products.*', 'categories.name as category_name')->join('categories', 'products.category_id', 'categories.id')->get();
        // dd($pizza->toArray());
        return view('user.main.detail', compact(['pizza', 'product']));
    }
    // direct order
    public function previousOrder()
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.history', compact('orders'));
    }
}
