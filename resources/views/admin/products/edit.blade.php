@extends('admin.layouts.master')

@section('title', 'Catagory List')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="ms-3">
                            <i class="fa-solid fa-arrow-left" onclick="history.back()"></i>
                        </div>
                        <div class="card-title">
                            <h3 class="text-center title-2">Edit your Product</h3>
                        </div>
                        <hr>

                        <form action="{{ route('products#update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-1">
                                    <input type="hidden" name="pizzaId" value="{{ $pizza->id }}">
                                    <img src="{{asset('storage/'.$pizza->image)}}" class="img-thumbnail shadow-sm"/>

                                    <div class="mt-3">
                                        <input type="file" name="pizzaImage" class="form-control @error('pizzaImage') is invalid @enderror">
                                        @error('pizzaImage')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="my-3">
                                        <button type="submit" class="btn bg-dark text-white col-12"><i class="fa-solid fa-file-arrow-up"></i> Update</button>
                                    </div>
                                </div>

                                <div class="row col-6 mt-1">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input name="pizzaName" type="text" value="{{old('pizzaName', $pizza->name)}}" class="form-control @error('pizzaName') is invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Pizza Name...">
                                        @error('pizzaName')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Description</label>
                                        <textarea name="pizzaDescription" class="form-control @error('pizzaDescription') is invalid @enderror" cols="30" rows="10">{{old('pizzaDescription', $pizza->description)}}</textarea>
                                        @error('pizzaDescription')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Category</label>
                                        <select name="pizzaCategory" class="form-control @error('pizzaCategory') is invalid @enderror">
                                            <option value="">Choose Pizza Category</option>
                                            @foreach ($category as $c)
                                            <option value="{{$c->id}}" @if ($pizza->category_id == $c->id) selected @endif>{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('pizzaCategory')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Price</label>
                                        <input id="cc-pament" name="pizzaPrice" type="number" value="{{old('pizzaPrice', $pizza->price)}}" class="form-control @error('pizzaPrice') is invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new pizza price...">
                                        @error('pizzaPrice')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Waiting time</label>
                                        <input id="cc-pament" name="pizzaWaitingTime" type="number" value="{{old('pizzaWaitingTime', $pizza->waiting_time)}}" class="form-control @error('pizzaWaitingTime') is invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new waiting time...">
                                        @error('pizzaWaitingTime')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">View Count</label>
                                        <input name="viewCount" class="form-control" value="{{old('viewCount', $pizza->view_count)}}" cols="30" rows="10" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Created at</label>
                                        <input id="cc-pament" name="created_at" type="text" value="{{$pizza->created_at->format('j F Y')}}" class="form-control" aria-required="true" aria-invalid="false" disabled>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
