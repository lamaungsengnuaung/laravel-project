<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Component\HttpFoundation\RequestStack;

class AjaxController extends Controller
{
    // return pizza list
    public function pizzaLists(Request $request)
    {
        logger($request->all());
        if ($request->status == 'A to Z ascending') {
            $data = Product::orderBy('name', 'asc')->get();
        } else {
            $data = Product::orderBy('name', 'desc')->get();
            // dd($data);
        }
        // dd($data);
        return $data;
    }

    // increase pizza viewCount
    public function viewCount(Request $request)
    {
        logger($request->all());
        $pizza = Product::where('id', $request->id)->first();
        $count = [
            'view_count' => $pizza->view_count + 1
        ];
        $updated = Product::where('id', $request->id)->update($count);
        $increaseViewCount = $updated->view_count;
        logger($increaseViewCount);
        return response()->json([$increaseViewCount], 200);
    }

    // add cart
    public function addcart(Request $request)
    {
        // logger($request->all());
        $cart = $this->getData($request);
        Cart::create($cart);
        return [
            'status' => 'success',
            'message' => 'Add to Cart',
        ];
    }
    // order pizza
    public function order(Request $request)
    {
        logger($request);
        // logger($request->toArray());
        $total = 3000;

        for ($i = 0; $i < count($request['$orderList']); $i++) {
            $order = OrderList::create($request['$orderList'][$i]);
            $total += $order->total;
        }
        // logger($order);
        Cart::where('user_id', Auth::user()->id)->delete();
        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $order->order_code,
            'total_price' => $total
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'order completed'
        ], 200);
    }

    // clear whole cart
    public function clearCart()
    {
        Cart::where('user_id', Auth::user()->id)->delete();
        return response()->json(['status' => 'true'], 200);
    }
    // clear current cart product
    public function clearProduct(Request $request)
    {
        // logger($request);
        $cart = Cart::where('user_id', Auth::user()->id)
            ->where('id', $request->cart_id)
            ->delete();
        // logger($cart);
    }
    // cart data
    private function getData($request)
    {
        return [
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'qty' => $request->count,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
