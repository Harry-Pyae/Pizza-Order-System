@extends('admin.layouts.master')

@section('title', 'Order List')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="table-responsive table-responsive-data2">

                    <a href="{{route('order#list')}}" class="text-dark"><i class="fa-solid fa-arrow-left me-1"></i> Back</a>

                    <div class="row col-5">
                        <div class="card mt-4">
                            <div class="card-body text-center">
                                <h3><i class="fa-solid fa-receipt me-2"></i> Order Info</h3>
                                <small class="text-info"><i class="fa-solid fa-circle-check me-2"></i>Included Delivery Charges</small>
                            </div>
                            <div class="card-body">
                                <div class="row my-2">
                                    <div class="col"><i class="fa-solid fa-user me-2"></i>User Name</div>
                                    <div class="col">{{strtoupper($orderList[0]->user_name)}}</div>
                                </div>
                                <div class="row my-2">
                                    <div class="col"><i class="fa-solid fa-barcode me-2"></i>Order Code</div>
                                    <div class="col">{{$orderList[0]->order_code}}</div>
                                </div>
                                <div class="row my-2">
                                    <div class="col"><i class="fa-solid fa-clock me-2"></i>Order Date</div>
                                    <div class="col">{{$orderList[0]->created_at->format("j F Y")}}</div>
                                </div>
                                <div class="row my-2">
                                    <div class="col"><i class="fa-brands fa-shopify me-2"></i>Total</div>
                                    <div class="col">{{$order->total_price}} kyats</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th class="col-0"></th>
                                <th>Order ID</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Order Code</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($orderList as $o)
                            <tr class="tr-shadow">
                                <td class="col-0"></td>
                                <td>{{$o->id}}</td>
                                <td class="col-3"><img src="{{asset('storage/'.$o->product_image)}}" class="img-thumbnail w-50" alt=""></td>
                                <td>{{$o->product_name}}</td>
                                <td>{{$o->qty}}</td>
                                <td>{{$o->total}} kyats</td>
                                <td>{{$o->order_code}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
@endsection
