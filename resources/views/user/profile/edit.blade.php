@extends('user.layouts.master')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Account Profile</h3>
                        </div>
                        <hr>

                        <form action="{{route('user#update', Auth::user()->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-1">
                                    @if (Auth::user()->image == null)
                                        @if (Auth::user()->gender == 'Male')
                                            <img src="{{ asset('image/default_user.png') }}" class="img-thumbnail shadow-sm" alt="Default User Image">
                                        @else
                                            <img src="{{ asset('image/female_default.png') }}" class="img-thumbnail shadow-sm" alt="Default User Image">
                                        @endif
                                    @else
                                        <img src="{{asset('storage/'.Auth::user()->image)}}" class="img-thumbnail shadow-sm"/>
                                    @endif

                                    <div class="mt-3">
                                        <input type="file" name="image" class="form-control @error('image') is invalid @enderror">
                                        @error('image')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="my-3">
                                        <button type="submit" class="btn bg-dark text-white col-12"><i class="fa-solid fa-file-arrow-up"></i> Update</button>
                                    </div>
                                </div>

                                <div class="col-6 mt-1">
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name" type="text" value="{{old('name', Auth::user()->name)}}" class="form-control @error('name') is invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new name...">
                                        @error('name')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email" type="email" value="{{old('email', Auth::user()->email)}}" class="form-control @error('email') is invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new email...">
                                        @error('email')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" name="phone" type="number" value="{{old('phone', Auth::user()->phone)}}" class="form-control @error('phone') is invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new phone...">
                                        @error('phone')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">gender</label>
                                        <select name="gender" class="form-control @error('gender') is invalid @enderror">
                                            <option value="Male" @if (Auth::user()->gender=='Male') selected @endif>Male</option>
                                            <option value="Female" @if (Auth::user()->gender=='Female') selected @endif>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Address</label>
                                        <textarea name="address" class="form-control @error('address') is invalid @enderror" cols="30" rows="10">{{old('address', Auth::user()->address)}}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Role</label>
                                        <input id="cc-pament" name="role" type="text" value="{{old('role', Auth::user()->role)}}" class="form-control" aria-required="true" aria-invalid="false" disabled>
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
