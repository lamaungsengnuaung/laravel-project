<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;

class RouteController extends Controller
{
    public function productList()
    {
        $data = Product::get();
        $response = [
            "product" => [
                "list" => $data
            ]
        ];
        return response()->json($response);
    }

    public function categoryList()
    {
        $data = Category::get();
        $response = [
            "category" => [
                "list" => [
                    "0" => $data
                ]
            ]
        ];
        return response()->json($response, 200);
    }

    public function deleteOrder($id)
    {
        $order = Order::where('id', $id)->first();
        if (empty($order)) {
            return response()->json(['status' => 'false', 'order' => 'There is no order.'], 500);
        }
        Order::where('id', $id)->delete();
        return response()->json(['status' => 'true', 'order' => $order], 200);
    }

    public function detail($id)
    {
        $response = Category::where('id', $id)->first();
        if (empty($response)) {
            return response()->json([
                'status' => 'false',
                'category' => 'There is no category.'
            ], 500);
        }
        return response()->json($response, 200);
    }
    public function createCategory(Request $request)
    {
        $this->categoryValidationCheck($request);
        $request = $this->requestCategoryData($request);
        $response = Category::create($request);
        return response()->json(['status' => 'true', 'category' => $response], 200);
    }

    public function updateCategory(Request $request)
    {
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        $response = Category::where('id', $request->id)->update($data);
        return response()->json(['status' => 'true'], 200);
    }

    public function createProduct(Request $request)
    {
        // $this->productValidationCheck($request, "create");
        $data = $this->requestProductData($request);
        Product::create($data);
        return response()->json(['status' => 'true', 'product', $data], 200);
    }

    private function requestProductData($request)
    {
        return [
            'name' => $request->name,
            'image' => $request->image,
            'description' => $request->description,
            'category_id' => $request->categoryId,
            'price' => $request->price,
            'waiting_time' => $request->waitingTime
        ];
    }

    private function categoryValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required|min:5|unique:categories,name,' . $request->id,
        ])->validate();
    }
    private function requestCategoryData($request)
    {
        return [
            'name' => $request->name
        ];
    }
}
