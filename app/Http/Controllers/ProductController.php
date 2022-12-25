<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // products list
    public function list(){
        $pizzas = Product::select('products.*', 'categories.name as category_name')
                ->when(request('key'), function($query){
                    $query->where('products.name','like','%'.request('key').'%');
                })
                ->leftJoin('categories', 'products.category_id', 'categories.id')
                ->orderBy('products.created_at', 'desc')
                ->paginate(3);
        $pizzas->appends(request()->all());
        return view('admin.products.pizzaList', compact('pizzas'));
    }

    // direct pizza create page
    public function createPage(){
        $categories = Category::select('id', 'name')->get();
        return view('admin.products.create', compact('categories'));
    }

    // create product
    public function create(Request $request) {
        $this->productValidationCheck($request, "create");
        $data = $this->requestProductInfo($request);

        $fileName = uniqid().$request->file('pizzaImage')->getClientOriginalName();
        $request->file('pizzaImage')->storeAs('public', $fileName);
        $data['image'] = $fileName;

        Product::create($data);
        return redirect()->route('products#list');
    }

    // details of product
    public function details($id){
        $pizza = Product::select('products.*', 'categories.name as category_name')
                ->leftJoin('categories', 'products.category_id', 'categories.id')
                ->where('products.id', $id)->first();
        return view('admin.products.details', compact('pizza'));
    }

    // edit product details
    public function editPage($id){
        $pizza = Product::where('id', $id)->first();
        $category = Category::get();
        return view('admin.products.edit', compact('pizza', 'category'));
    }

    // update product details
    public function update(Request $request){

        $data = $this->requestProductInfo($request);
        $this->productValidationCheck($request, "update");

        if($request->hasFile('pizzaImage')){
            $oldImageName = Product::where('id', $request->pizzaId)->first();
            $oldImageName = $oldImageName->image;

            if($oldImageName != null){
                Storage::delete('public/'.$oldImageName);
            }

            $fileName = uniqid().$request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        Product::where('id', $request->pizzaId)->update($data);
        return redirect()->route('products#list');
    }

    // delete product
    public function delete($id){
        Product::where('id', $id)->delete();
        return redirect()->route('products#list')->with(['deleteSuccess' => 'Product deleted']);
    }

    // request Product Info
    private function requestProductInfo($request){
        return [
            'category_id' => $request->pizzaCategory,
            'name' => $request->pizzaName,
            'description' => $request->pizzaDescription,
            'price' => $request->pizzaPrice,
            'waiting_time' => $request->pizzaWaitingTime
        ];
    }

    // product Validation Check
    private function productValidationCheck($request, $action){

        $validationRules = [
            'pizzaName' => 'required|min:5|unique:products,name,'.$request->pizzaId,
            'pizzaCategory' => 'required',
            'pizzaDescription' => 'required|min:10',
            'pizzaWaitingTime' => 'required',
            'pizzaPrice' => 'required',
        ];

        $validationRules['pizzaImage'] = $action == "create" ? 'required|mimes:jpg,jpeg,png|file' : "mimes:jpg,jpeg,png|file";

        Validator::make($request->all(), $validationRules)->validate();
    }
}
