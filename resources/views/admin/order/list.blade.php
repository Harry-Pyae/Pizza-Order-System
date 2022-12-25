@extends('admin.layouts.master')

@section('title', 'Orders')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Order List</h2>
                        </div>
                    </div>
                </div>

                @if(session('deleteSuccess'))
                <div class="col-4 offset-8">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i> {{session('deleteSuccess')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-4">
                        <h4 class="text-secondary">Search Key: <span class="text-info">{{request('key')}}</span></h4>
                    </div>
                    <div class="col-3 offset-5">
                        <form action="{{route('order#list')}}" method="get">
                            @csrf
                            <div class="d-flex">
                                <input type="text" name="key" class="form-control" placeholder="Search..." value="{{request('key')}}">
                                <button class="btn bg-light text-dark" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-1 offset-10 bg-white shadow-sm p-2 my-1 text-center">
                        <h3> <i class="fa-solid fa-database"></i> - {{ count($order) }}</h3>
                    </div>
                </div>

                <form action="{{ route('admin#changeStatus') }}" method="get">
                    <div class="input-group mb-5">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <h3> <i class="fa-solid fa-database mr-2"></i> - {{ count($order) }}</h3>
                            </span>
                        </div>
                        <select id="orderStatus" name="orderStatus" class="col-2 me-1">
                            <option value="">All</option>
                            <option value="0" @if (request('orderStatus') == '0') selected @endif>Pending</option>
                            <option value="1" @if (request('orderStatus') == '1') selected @endif>Accepted</option>
                            <option value="2" @if (request('orderStatus') == '2') selected @endif>Rejected</option>
                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-sm input-group-text bg-dark text-white">Search</button>
                        </div>
                    </div>
                </form>

                @if (count($order) != 0)
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Total Amount</th>
                                <th>Order Code</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($order as $o)
                            <tr class="tr-shadow">
                                <input type="hidden" class="orderId" value="{{$o->id}}">
                                <td class="col-1">{{$o->user_id}}</td>
                                <td class="col-2">{{$o->user_name}}</td>
                                <td class="col-2">{{$o->total_price}} kyats</td>
                                <td class="col-2"><a href="{{route('admin#listInfo', $o->order_code)}}">{{$o->order_code}}</a></td>
                                <td class="col-2">{{$o->created_at->format('j F Y')}}</td>
                                <td class="col-2">
                                    <select name="status" class="form-control statusChange">
                                        <option value="0" @if ($o->status == 0) selected @endif>Pending</option>
                                        <option value="1" @if ($o->status == 1) selected @endif>Accepted</option>
                                        <option value="2" @if ($o->status == 2) selected @endif>Rejected</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <h3 class="text-secondary text-center mt-5">There is no order right now.</h3>
                @endif
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptSource')
<script>
    $(document).ready(function(){
        // $('#orderStatus').change(function(){
        //     $status = $('#orderStatus').val();

        //     $.ajax({
        //         type : 'get',
        //         url : '/order/ajax/status',
        //         data : {
        //             'status' : $status,
        //         } ,
        //         dataType : 'json',
        //         success :  function(response){
        //             $list = '';
        //             for($i=0; $i<response.length; $i++){

        //                 $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
        //                 $dbDate = new Date(response[$i].created_at);
        //                 console.log($dbDate);
        //                 $finalDate = $dbDate.getDate() + " " + $months[$dbDate.getMonth()] + " " + $dbDate.getFullYear();

        //                 if(response[$i].status == 0){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0" selected>Pending</option>
        //                         <option value="1">Accepted</option>
        //                         <option value="2">Rejected</option>
        //                     </select>
        //                     `;
        //                 } else if (response[$i].status == 1){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0">Pending</option>
        //                         <option value="1" selected>Accepted</option>
        //                         <option value="2">Rejected</option>
        //                     </select>
        //                     `;
        //                 } else if (response[$i].status == 2){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0">Pending</option>
        //                         <option value="1">Accepted</option>
        //                         <option value="2" selected>Rejected</option>
        //                     </select>
        //                     `;
        //                 }
        //                 ;

        //                 $list += `
        //                 <tr class="tr-shadow">
        //                     <input type="hidden" class="orderId" value="${response[$i].id}">
        //                     <td class="col-1">${response[$i].user_id}</td>
        //                     <td class="col-2">${response[$i].user_name}</td>
        //                     <td class="col-2">${response[$i].total_price} kyats</td>
        //                     <td class="col-2">${response[$i].order_code}</td>
        //                     <td class="col-2">${$finalDate}</td>
        //                     <td class="col-2">${$statusMessage}</td>
        //                 </tr>`;
        //             }
        //             $('#dataList').html($list);
        //         }
        //     });
        // });

        $('.statusChange').change(function(){
            $currentStatus = $(this).val();
            $parentNode = $(this).parents("tr");
            $orderId = $parentNode.find('.orderId').val();

            $data = {
                'orderId' : $orderId,
                'status' : $currentStatus,
            }

            console.log($data);

            $.ajax({
                type : 'get',
                url : '/order/ajax/change/status',
                data : $data,
                dataType : 'json',
            });
            location.reload();
        });
        // $.ajax({
        //     type : 'get',
        //     url : '/user/ajax/pizza/list',
        //     data :
        //     dataType : 'json',
        //     success :  function(response){
        //         console.log(response)
        //     }
        // });
    });
</script>
@endsection
