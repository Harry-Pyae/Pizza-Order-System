@extends('admin.layouts.master')

@section('title', 'Change Role')

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
                            <h3 class="text-center title-2">Account Profile</h3>
                        </div>
                        <hr>

                        <form action="{{route('admin#change', $account->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-1">
                                    @if ($account->image == null)
                                        @if ($account->gender == 'Male')
                                            <img src="{{ asset('image/default_user.png') }}" class="img-thumbnail shadow-sm" alt="Default User Image">
                                        @else
                                            <img src="{{ asset('image/female_default.png') }}" class="img-thumbnail shadow-sm" alt="Default User Image">
                                        @endif
                                    @else
                                        <img src="{{asset('storage/'.$account->image)}}"/>
                                    @endif

                                    <div class="my-3">
                                        <button type="submit" class="btn bg-black text-white col-12"><i class="fa-solid fa-file-arrow-up me-1"></i> Update</button>
                                    </div>
                                </div>

                                <div class="row col-6 mt-1">
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Name</label>
                                        <input id="cc-pament" disabled name="name" type="text" value="{{old('name', $account->name)}}" class="form-control @error('name') is invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new name...">
                                        @error('name')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Role</label>
                                        <select name="role" class="form-control">
                                            <option value="admin" @if ($account->role== 'admin') selected @endif>Admin</option>
                                            <option value="user" @if ($account->role== 'user') selected @endif>User</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Email</label>
                                        <input id="cc-pament" disabled name="email" type="email" value="{{old('email', $account->email)}}" class="form-control @error('email') is invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new email...">
                                        @error('email')
                                            <div class="invalid-feedback d-block">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" disabled name="phone" type="number" value="{{old('phone', $account->phone)}}" class="form-control @error('phone') is invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new phone...">
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">gender</label>
                                        <select name="gender" disabled class="form-control">
                                            <option value="Male" @if ($account->gender=='Male') selected @endif>Male</option>
                                            <option value="Female" @if ($account->gender=='Female') selected @endif>Female</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Address</label>
                                        <input id="cc-pament" disabled name="address" type="text" value="{{old('address', $account->address)}}" class="form-control" aria-required="true" aria-invalid="false" disabled>
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
