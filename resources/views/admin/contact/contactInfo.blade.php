@extends('admin.layouts.master')

@section('title', 'Detailed Contact from User')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-3 offset-3">
                    <a href="{{route('admin#userContact')}}"><button class="btn bg-dark text-white my-3 rounded">Back</button></a>
                </div>
            </div>
            <div class="col-lg-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Message from User</h3>
                        </div>
                        <hr>
                        <form action="" method="" novalidate="novalidate">
                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">Name</label>
                                <input id="cc-pament" name="name" type="text" value="{{ $contactInfo->name }}" class="form-control" aria-required="true" aria-invalid="false" disabled>
                            </div>

                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">Email</label>
                                <input id="cc-pament" name="email" type="text" value="{{ $contactInfo->email }}" class="form-control" aria-required="true" aria-invalid="false" disabled>
                            </div>

                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">Message</label>
                                <textarea name="message" class="form-control" cols="30" rows="10" disabled>{{ $contactInfo->message }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="cc-payment" class="control-label mb-1">Message sent at</label>
                                <input id="cc-pament" name="email" type="text" value="{{ $contactInfo->created_at->format("j F Y") }}" class="form-control" aria-required="true" aria-invalid="false" disabled>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

