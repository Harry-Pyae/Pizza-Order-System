<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\orderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    // return pizza list
    public function pizzaList(Request $request){
        if ($request->status == 'asc') {
            $pizza = Product::orderBy('created_at', 'asc')->get();
        } else if ($request->status == 'desc'){
            $pizza = Product::orderBy('created_at', 'desc')->get();
        }
        return response()->json($pizza, 200);
    }

    // increase view count
    public function increaseViewCount(Request $request){
        $pizza = Product::where('id', $request->productId)->first();

        $viewCount = [ 'view_count' => $pizza->view_count + 1 ];

        Product::where('id', $request->productId)->update($viewCount);
    }

    // add to cart
    public function addToCart(Request $request){
        $data = $this->getOrderData($request);
        Cart::create($data);
        $response = [
            'status' => 'Success',
            'message' => 'Added to your Cart'
        ];
        return response()->json($response, 200);
    }

    private function getOrderData($request){
        return [
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'qty' => $request->count,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    // order imported to admins
    public function order(Request $request){
        $total = 0;
        foreach($request->all() as $item){
            $data = orderList::create([
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'total' => $item['total'],
                'order_code' => $item['order_code'],
                ]);
            $total += $data->total;
        }
        Cart::where('user_id', Auth::user()->id)->delete();

        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $total+3000,
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'Order Submission Completed'
        ], 200);
    }

    // clear product from database
    public function clearCurrentProduct(Request $request){
        Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $request->productId)
            ->where('id', $request->orderId)
            ->delete();
    }

    // clear cart from database
    public function clearCart(){
        Cart::where('user_id', Auth::user()->id)->delete();
    }
}
