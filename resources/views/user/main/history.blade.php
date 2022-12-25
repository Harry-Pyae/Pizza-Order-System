@extends('user.layouts.master')

@section('content')

    <!-- History Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 offset-2 table-responsive mb-5" style="height: 434px;">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr class="text-white">
                            <th></th>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($order as $o)
                        <tr class="text-black">
                            <td></td>
                            <td class="align-middle">{{$o->created_at->format('j F Y')}}</td>
                            <td class="align-middle">{{$o->order_code}}</td>
                            <td class="align-middle">{{$o->total_price}}</td>
                            <td class="align-middle">
                                @if ($o->status == 0)
                                    <span class="text-info"> <i class="fa-solid fa-clock me-2"></i>Pending... </span>
                                @elseif ($o->status == 1)
                                    <span class="text-success"> Success<i class="fa-solid fa-check ms-2"></i> </span>
                                @elseif ($o->status == 2)
                                    <span class="text-danger"> Rejected<i class="fa-solid fa-circle-xmark ms-2"></i> </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">{{$order->links()}}</div>
            </div>
        </div>
    </div>
    <!-- History End -->

@endsection

@section('scriptSource')
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection
