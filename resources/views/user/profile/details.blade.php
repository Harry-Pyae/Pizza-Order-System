@extends('user.layouts.master')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Account Info</h3>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-4 offset-1 te px-5 mb-2">
                                @if(session('UpdateSuccess'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fa-regular fa-circle-xmark"></i> {{session('UpdateSuccess')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 offset-2">
                                @if (Auth::user()->image == null)
                                    @if (Auth::user()->gender == 'Male')
                                        <img src="{{ asset('image/default_user.png') }}" class="img-thumbnail shadow-sm" alt="Default User Image">
                                    @else
                                        <img src="{{ asset('image/female_default.png') }}" class="img-thumbnail shadow-sm" alt="Default User Image">
                                    @endif
                                @else
                                    <img src="{{asset('storage/'.Auth::user()->image)}}"/>
                                @endif
                            </div>
                            <div class="col-5 offset-1">
                                <h3 class="m-1 my-2 "><i class="fa-solid fa-file-signature"></i> {{Auth::user()->name}}</h3>
                                <h3 class="m-1 my-2 "><i class="fa-solid fa-envelope"></i> {{Auth::user()->email}}</h3>
                                <h3 class="m-1 my-2 "><i class="fa-solid fa-mobile"></i> {{Auth::user()->phone}}</h3>
                                <h3 class="m-1 my-2 "><i class="fa-sharp fa-solid fa-mars-and-venus"></i> {{Auth::user()->gender}}</h3>
                                <h3 class="m-1 my-2 "><i class="fa-solid fa-map-location-dot"></i> {{Auth::user()->address}}</h3>
                                <h3 class="m-1 my-2 "><i class="fa-solid fa-user-clock"></i> {{Auth::user()->created_at->format('j F Y')}}</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4 offset-2 mt-3">
                                <a href="{{route('user#edit')}}">
                                    <button class="btn bg-dark text-white">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Profile
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
