@extends('user.layouts.master')

@section('content')
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div class="ms-3">
                    <button class="btn btn-sm">
                        <a href="{{route('user#home')}}" class="text-black text-decoration-none">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </button>
                </div>
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{asset('storage/'.$pizza->image)}}" alt="Image">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{$pizza->name}}</h3><hr>
                    <input type="hidden" id="userId" value="{{ Auth::user()->id }}">
                    <input type="hidden" id="pizzaId" value="{{ $pizza->id }}">
                    <div class="d-flex mb-3">
                        <h5 class="pt-1"><i class="fa-sharp fa-solid fa-eye me-1"></i> {{$pizza->view_count + 1}}</h5>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4"> Price - {{$pizza->price}} kyats</h3>
                    <h3 class="font-weight-semi-bold mb-4"> Waiting Time - {{$pizza->waiting_time}} mins</h3>
                    <p class="mb-4">{{$pizza->description}}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-light btn-minus border border-dark rounded">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-light border-0 text-center" value="1" id="orderCount">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-light btn-plus border border-dark rounded">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button id="addCartBtn" class="btn btn-light px-3 border border-dark rounded"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                @foreach ($pizzaList as $p)
                <div class="product-item bg-light">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{asset('storage/'.$p->image)}}" style="height: 300px;" alt="">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href="{{route('user#pizzaDetails', $p->id)}}"><i class="fa-solid fa-circle-info"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <span class="h6 text-decoration-none text-truncate">{{$p->name}}</span>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>Price - {{$p->price}} kyats</h5>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small>(99)</small>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
        </div>
    </div>
    <!-- Products End -->

@endsection

@section('scriptSource')
<script>
    $(document).ready(function(){

        // increase view count
        $.ajax({
            type : 'get',
            url : '/user/ajax/increase/viewCount',
            data : { 'productId' : $('#pizzaId').val() }
        });

        // add to cart button
        $('#addCartBtn').click(function(){
            $source = {
                'userId' :  ($('#userId').val()),
                'pizzaId' : ($('#pizzaId').val()),
                'count' :   ($('#orderCount').val()),
            }

            $.ajax({
                type : 'get',
                url : '/user/ajax/cart',
                data : $source,
                dataType : 'json',
                success :  function(response){
                    if(response.status == 'Success'){
                        window.location.href = "/user/homePage";
                    }
                }
            });
        });
    });
</script>
@endsection


