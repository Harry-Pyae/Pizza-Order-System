<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\orderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    // get all product lists
    public function productList(){
        $products = Product::get();
        return response()->json($products, 200);
    }

    // get all category lists
    public function categoryList(){
        $category = Category::get();
        return response()->json($category, 200);
    }

    // get all order lists
    public function orderLists(){
        $orderList = orderList::get();
        return response()->json($orderList, 200);
    }

    // post method

    // create category
    public function categoryCreate(Request $request){
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $response = Category::create($data);
        return response()->json($response, 200);
    }

    // create contact
    public function contactCreate(Request $request){
        $data = $this->getContactData($request);
        Contact::create($data);

        $contact = Contact::get();
        return response()->json($contact, 200);
    }

    private function getContactData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    // category details
    public function categoryDetails($id){
        $data = Category::where('id', $id)->first();

        if(isset($data)){
            return response()->json(['status' => true , 'Category' => $data], 200);
        }

        return response()->json(['status' => false , 'message' => 'There is no category for that ID'], 200);
    }

    // update Category details
    public function updateCategory(Request $request){
        $category = $request->id;
        $dbSource = Category::where('id', $request->id)->first();

        if(isset($dbSource)){
            $data = $this->getCategoryData($request);
            Category::where('id', $category)->update($data);
            $response = Category::where('id', $request->id)->first();
            return response()->json(['status' => true , 'message' => 'Category details updated', 'Category' => $response], 200);
        }
        return response()->json(['status' => false , 'message' => 'Category not found'], 500);
    }

    private function getCategoryData($request){
        return [
            'name' => $request->name,
            'updated_at' => Carbon::now()
        ];
    }

    // delete category
    public function deleteCategory($id){
        $data = Category::where('id', $id)->first();

        if(isset($data)){
            Category::where('id', $id)->delete();
            return response()->json(['status' => true , 'deleteData' => $data , 'message' => 'delete success'], 200);
        }

        return response()->json(['status' => false , 'message' => 'There is no category for that ID'], 200);
    }
}
