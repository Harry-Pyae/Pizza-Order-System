<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // Category List
    public function list(){
        $categories = Category::when(request('key'), function($query){
                $query->where('name', 'like', '%'.request('key').'%');
            })
                ->orderBy('id', 'desc')
                ->paginate(5);
        $categories->appends(request()->all());
        return view('admin.category.list', compact('categories'));
    }

    // create Category Page
    public function createPage(){
        return view('admin.category.create');
    }

    // create Category
    public function create(Request $request){
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list');
    }

    // edit Category
    public function edit($id){
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    // update Category
    public function update(Request $request){
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::where('id', $request->categoryID)->update($data);
        return redirect()->route('category#list');
    }

    // delete Category
    public function delete($id){
        Category::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => 'Category Deleted...']);
    }

    // private functions
    // category validation check
    private function categoryValidationCheck($request){
        Validator::make($request->all(), [
            'categoryName' => 'required|min:4|unique:categories,name,'.$request->categoryID
        ])->validate();
    }

    // request category data
    private function requestCategoryData($request){
        return [
            'name' => $request->categoryName,
        ];
    }
}
