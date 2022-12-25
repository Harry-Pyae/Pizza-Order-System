@extends('admin.layouts.master')

@section('title', 'Catagory List')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="row">
        <div class="col-3 offset-7 mb-2">
            @if(session('UpdateSuccess'))
            <div class="col-4 offset-8">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-regular fa-circle-xmark"></i> {{session('UpdateSuccess')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
            </div>
            @endif
        </div>
    </div>
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="ms-3">
                            <i class="fa-solid fa-arrow-left" onclick="history.back()"></i>
                        </div>
                        <div class="card-title">
                            <h3 class="text-center title-2">Product Details</h3>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-3 offset-2">
                                <img src="{{asset('storage/'.$pizza->image)}}"/>
                            </div>
                            <div class="col-7">
                                <div class="mx-1 text-bold my-2 w-50 text-center bg-black text-white fw-bold fs-4"><i class="fa-solid fa-pizza-slice me-2"></i> {{$pizza->name}}</div>
                                <span class="mx-1 my-3 btn bg-dark text-white"><i class="fa-solid fa-money-bill-wave me-2"></i> {{$pizza->price}} kyats </span>
                                <span class="mx-1 my-3 btn bg-dark text-white"><i class="fa-solid fa-hourglass-half me-2"></i> {{$pizza->waiting_time}} mins </span>
                                <span class="mx-1 my-3 btn bg-dark text-white"><i class="fa-solid fa-eye me-2"></i> {{$pizza->view_count}}</span>
                                <span class="mx-1 my-3 btn bg-dark text-white"><i class="fa-solid fa-clone me-2"></i> {{$pizza->category_name}}</span>
                                <span class="mx-1 my-3 btn bg-dark text-white"><i class="fa-solid fa-clock me-2"></i> {{$pizza->created_at->format('j F Y')}}</span>
                                <h3 class="m-1 my-3 "><i class="fa-solid fa-file-waveform me-2"></i> Details </h3>
                                <div>{{$pizza->description}}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4 offset-2 mt-3">
                                <a href="{{route('products#editPage', $pizza->id)}}">
                                    <button class="btn bg-dark text-white">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Product
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
