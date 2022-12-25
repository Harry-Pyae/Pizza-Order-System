@extends('user.layouts.master')

@section('title', 'Contact to Admins')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-3 offset-3">
                    <a href="{{route('user#home')}}"><button class="btn bg-dark text-white my-3 rounded">Back</button></a>
                </div>
            </div>
            <div class="col-lg-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Write Your Message</h3>
                        </div>
                        <hr>
                        <form action="{{route('user#contactSend')}}" method="post" novalidate="novalidate">
                            @csrf
                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">Name</label>
                                <input id="cc-pament" name="name" type="text" value="{{old('name', Auth::user()->name)}}" class="form-control" aria-required="true" aria-invalid="false" disabled>
                            </div>

                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">Email</label>
                                <input id="cc-pament" name="email" type="text" value="{{old('email', Auth::user()->email)}}" class="form-control" aria-required="true" aria-invalid="false" disabled>
                            </div>

                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">Message</label>
                                <textarea name="message" class="form-control @error('message') is invalid @enderror" cols="30" rows="10" placeholder="Enter your message"></textarea>

                                @error('message')
                                    <small class="invalid-feedback d-block">
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>

                            <div>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Send to Admins</span>
                                    {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                    <i class="fa-solid fa-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
