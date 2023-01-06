<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // direct list
    public function list()
    {
        $key = request('searchData');
        // logger($key);
        $product = Product::select('products.*', 'categories.name as category_name')
            ->where('products.name', 'like', "%{$key}%")->orWhere('products.price', '<=', "$key")
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->orderBy('products.created_at', 'desc')
            ->paginate(3);
        // dd($product);
        $product->appends(request()->all());
        return view('admin.product.pizzalist', compact('product'));
    }
    // direct Create Page
    public function createPage()
    {
        $categories = Category::get();
        return view('admin.product.create', compact('categories'));
    }
    // create product
    public function create(Request $request)
    {
        $this->productValidationCheck($request, "create");
        // dd($request->toArray());
        $data = $this->requestProductInfo($request);
        // dd($data);
        if ($request->hasFile('image')) {
            $fileName = date('jmYis') . '_' . $request->file('image')->getClientOriginalName();
            $data['image'] = $fileName;
            $request->file('image')->storeAs('public', $fileName); // no need to add '/'
        }
        // dd($request->image);
        $test =  Product::create($data);
        // dd($test);
        return redirect()->route('products#list');
    }
    // delete product
    public function delete($id)
    {
        // dd($id)
        Product::where('id', $id)->delete();
        return back()->with(['deleteMessage' => 'Product Deleted ...']);
    }
    // edit page
    public function editPage($id)
    {
        $product = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $id)->first();
        // dd($id, $product);
        $categories = Category::get();
        // dd($categories);
        return view('admin.product.edit', compact(['categories', 'product']));
    }
    // update pizza
    public function update(Request $request, $id)
    {
        $this->productValidationCheck($request, "update");
        $data =  $this->requestProductInfo($request);
        if ($request->hasFile('image')) {
            $dbData = Product::where('id', $id)->first();
            $oldImageName = $dbData['image'];
            if ($oldImageName != Null) {
                Storage::delete('public/' . $oldImageName);

                $fileName = date('jmYis') . '_' . $request->file('image')->getClientOriginalName();
                $data['image'] = $fileName;
                $request->file('image')->storeAs('public', $fileName);
            }
        }

        Product::where('id', $id)->update($data);
        return redirect()->route('products#list')->with(['updateMessage' => 'Data Update Success ..']);
    }
    // detail
    public function detail($id)
    {
        $product = Product::where('id', $id)->first();
        $categories = Category::select('id', 'name')->where('id', $product->category_id)->first();
        // dd($categories);
        return view('admin.product.detail', compact(['product', 'categories']));
    }
    // request data
    private function requestProductInfo($request)
    {
        return [
            'name' => $request->name,
            'category_id' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'waiting_time' => $request->waitingtime,

        ];
    }
    // validation
    private function productValidationCheck($request, $action)
    {
        // dd($action);
        $productValidationRules = [
            'name' => 'required | unique:products,name,' . $request->id,
            'category' => 'required',
            'description' => 'required',
            'price' => 'required',
            'waitingtime' => 'required',
        ];
        $productValidationRules['image'] = $action == "create" ? 'required|mimes:jpg,bmp,png,jpeg,webp|file' : "mimes:jpg,jpeg,png,webp|file";
        Validator::make($request->all(), $productValidationRules)->validate();
    }
}
