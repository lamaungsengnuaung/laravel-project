<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class OrderController extends Controller
{
    // list direct
    public function list()
    {
        $key = request('filterStatus');
        $orders = Order::select('orders.*')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($orders->toArray());
        return view('admin.order.list', compact('orders'));
    }
    // List info
    public function listInfo($ordercode)
    {
        $data = OrderList::select('*', 'users.name as user_name')
            ->leftJoin('users', 'users.id', 'order_lists.user_id')
            ->leftJoin('products', 'products.id', 'order_lists.product_id')
            ->where('order_code', $ordercode)->get();
        $totalprice = Order::where('order_code', $ordercode)->first();
        $totalprice = $totalprice->total_price;
        // dd($totalprice);
        // dd($data->toArray());
        return view('admin.order.detail', compact('data', 'totalprice'));
    }


    // Ajax Change Status
    public function ajaxStatus(Request $request)
    {
        logger($request->currentStatus);
        $changes = Order::where('id', $request->orderId)->update(['status' => $request->currentStatus]);
        // logger($changes);

        return [
            'status' => true,
            'message' => 'Status changing success',
        ];
    }
    // Filter by Status
    public function filter(Request $request)
    {
        // dd(isset($request));
        $orders = Order::select('orders.*')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->where('orders.user_id', $request->searchData)
            ->orwhere('orders.status', $request->filterStatus)
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($orders->toArray());
        return view('admin.order.list', compact('orders'));
    }

    public function ajaxFilter(Request $request)
    {
        $orders = Order::select('orders.*')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->orderBy('created_at', 'desc');
        if ($request->currentStatus == 9) {
            $orders = $orders->get();
        } else {
            $orders = $orders->where('orders.status', $request->currentStatus)->get();
            // $date = $orders->first();
            // $date = $orders->where('orders.status', $request->currentStatus)->first();
            // $date = $date['created_at'];
            // logger($date);


            // logger($orders->created_at);
            // logger($orders['created_at']);
        }
        return response()->json($orders, 200);
    }
}
