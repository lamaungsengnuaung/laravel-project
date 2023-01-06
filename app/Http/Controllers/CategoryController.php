<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // direct category list page
    public function list()
    {
        // http://127.0.0.1:8000/category/list?_token=GQydiSWohQIU1xmKVdX5xhZvpM6hQ81txI735R6n&searchData=+user
        $key = request('searchData');
        // dd($key);
        $categories = Category::where('name', 'like', "%{$key}%")
            ->orWhere('created_at', 'like', "%{$key}%")->orderBy('id', 'desc')->paginate(3);
        $categories->appends(request()->all());
        // dd($categories);
        return view('admin.category.list', compact('categories'));
    }

    // direct category create page
    public function createPage()
    {
        return view('admin.category.create');
    }

    // create category item
    public function create(Request $request)
    {
        // dd($request->toArray());
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);

        return redirect()->route('category#list');
    }

    // delete category
    public function categoryDelete($id)
    {
        $delete = Category::where('id', '=', $id);
        // dd($delete);
        $delete->delete();
        return back()->with(['deleteSuccess' => 'Category Deleted ...']);
    }

    // edit category
    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        // dd($category->name);
        return view('admin.category.edit', compact('category'));
    }
    // update
    public function update(Request $request)
    {
        // dd($request->toArray());

        $data = $this->requestCategoryData($request);
        if ($request->name != $data['name']) {
            $this->categoryValidationCheck($request);
        }
        Category::where('id', $request->id)->update($data);
        // dd($request->toArray());
        return redirect()->route('category#list')->with(['updateMessage' => 'Category Lists Update Success ..']);
    }

    /**
     * search category item
     * public function search(Request $request)
     * {
     *     $key = $request->searchData;
     *     if (isset($key)) {

     *         $search = Category::where('name', 'like', "%{$key}%")
     *             ->orWhere('created_at', 'like', "%{$key}%")
     *             ->get();
     *     }
     *     return back();
     * }
     */
    // category ValidationCheck
    private function categoryValidationCheck($request)
    {
        // dd($request->all());
        // $id = $request->id;
        Validator::make($request->all(), [
            'categoryName' => 'required|min:5|unique:categories,name,' . $request->id,
        ])->validate();
    }

    // request category data
    private function requestCategoryData($request)
    {
        // dd($request->toArray());
        return ['name' => $request->categoryName];
    }
}
