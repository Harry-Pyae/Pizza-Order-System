@extends('user.layouts.master')

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pr-3">Filter by Categories</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="d-flex align-items-center justify-content-between px-2 bg-black text-white">
                            <label class="mt-2" for="price-all">Categories</label>
                            <span class="badge border font-weight-normal">{{ count($category) }}</span>
                        </div><hr>

                        <div class="d-flex align-items-center justify-content-between mb-3 pt-1">
                            <a href="{{route('user#home')}}" class="text-dark"><label class="h6" for="price-1">All</label></a>
                        </div><hr>

                        @foreach ($category as $c)
                        <div class="d-flex align-items-center justify-content-between mb-3 pt-1">
                            <a href="{{route('user#filter', $c->id)}}" class="text-dark"><label class="h6" for="price-1">{{$c->name}}</label></a>
                        </div>
                        @endforeach
                    </form>
                </div>
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="{{route('user#cartList')}}">
                                    <button type="button" class="btn bg-black text-white rounded text-decoration-none position-relative me-2">
                                        <i class="fa-solid fa-cart-shopping me-2"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill">{{count($cart)}}</span>
                                    </button>
                                </a>
                                <a href="{{route('user#history')}}">
                                    <button type="button" class="btn bg-black text-white rounded text-decoration-none position-relative">
                                        <i class="fa-solid fa-clock-rotate-left me-2"></i> History
                                        <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill">{{count($history)}}</span>
                                    </button>
                                </a>
                            </div>
                            <div class="row ml-2 mr-2">
                                <div class="col-12 te mt-4">
                                    @if(session('MessageSent'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fa-regular fa-circle-xmark"></i> {{session('MessageSent')}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-2">
                                <select name="sorting" id="sortingOption" class="form-control">
                                    <option value="">Choose One Option</option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="dataList">
                        @if (count($pizza) != 0)
                        @foreach ($pizza as $p)
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4" id="myForm">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" style="height: 300px;" src="{{asset('storage/'.$p->image)}}" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href="{{route('user#pizzaDetails', $p->id)}}"><i class="fa-solid fa-circle-info"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h4 text-black" href="">{{ $p->name }}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="p-1 mt-3">
                            <h2 class="text-center text-white fs-1">
                                <span class=" bg-info p-3 rounded shadow-sm"> There is no pizza here! <i class="fa-solid fa-face-sad-tear"></i></span>
                            </h2>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@section('scriptSource')
<script>
    $(document).ready(function(){
        // $.ajax({
        //     type : 'get',
        //     url : '/user/ajax/pizza/list',
        //     data :
        //     dataType : 'json',
        //     success :  function(response){
        //         console.log(response)
        //     }
        // });

        $('#sortingOption').change(function(){
            $eventOption = $('#sortingOption').val();

            if ($eventOption == 'asc') {
                $.ajax({
                    type : 'get',
                    url : '/user/ajax/pizza/list',
                    data : {'status' : 'asc'} ,
                    dataType : 'json',
                    success :  function(response){
                        $list = '';
                        for($i=0;$i<response.length;$i++){
                            $list += `
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4" id="myForm">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" style="height: 300px;" src="{{ asset('storage/${response[$i].image}') }}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h4 text-black" href="">${response[$i].name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5 class="text-black ml-2">${response[$i].price}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                        }
                        $('#dataList').html($list);
                    }
                })
            } else if($eventOption == 'desc'){
                $.ajax({
                    type : 'get',
                    url : '/user/ajax/pizza/list',
                    data : {'status' : 'desc'} ,
                    dataType : 'json',
                    success :  function(response){
                        $list = '';
                        for($i=0;$i<response.length;$i++){
                            $list += `
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4" id="myForm">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" style="height: 300px;" src="{{ asset('storage/${response[$i].image}') }}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h4 text-black" href="">${response[$i].name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5 class="text-black ml-2">${response[$i].price}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                        }
                        $('#dataList').html($list);
                    }
                })
            }
        });
    });
</script>
@endsection
