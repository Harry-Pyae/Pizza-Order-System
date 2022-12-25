<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\orderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // direct order list page
    public function orderList(){
        $order = Order::select('orders.*', 'users.name as user_name')
                ->when(request('key'), function($query){
                    $query->where('users.name','like','%'.request('key').'%');
                })
                ->leftJoin('users', 'users.id', 'orders.user_id')
                ->orderBy('orders.created_at', 'desc')
                ->get();
        return view('admin.order.list', compact('order'));
    }

    // change list
    public function changeStatus(Request $request){

        $order = Order::select('orders.*', 'users.name as user_name')
                ->leftJoin('users', 'users.id', 'orders.user_id')
                ->orderBy('orders.created_at', 'desc');

        if($request->orderStatus == null){
            $order = $order->get();
        }else{
            $order = $order->where('orders.status', $request->orderStatus)->get();
        }

        return view('admin.order.list', compact('order'));
    }

    // change status with ajax
    public function ajaxChangeStatus(Request $request){
        Order::where('id', $request->orderId)->update(['status' => $request->status]);

        $order = Order::select('orders.*', 'users.name as user_name')
                ->leftJoin('users', 'users.id', 'orders.user_id')
                ->orderBy('orders.created_at', 'desc')
                ->get();
        return view('admin.order.list', compact('order'));
    }

    // list info
    public function listInfo($orderCode){
        $order = Order::where('order_code', $orderCode)->first();
        $orderList = orderList::select('order_lists.*', 'users.name as user_name', 'products.image as product_image', 'products.name as product_name')
                    ->leftJoin('users', 'users.id', 'order_lists.user_id')
                    ->leftJoin('products', 'products.id', 'order_lists.product_id')
                    ->where('order_code', $orderCode)
                    ->get();
        return view('admin.order.productList', compact('orderList', 'order'));
    }
}
