@extends('admin.layouts.master')

@section('title', 'Contact from Users')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Contact List</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <h4 class="text-secondary">Search Key: <span class="text-info">{{request('key')}}</span></h4>
                    </div>
                    <div class="col-3 offset-5">
                        <form action="{{route('admin#userContact')}}" method="get">
                            @csrf
                            <div class="d-flex">
                                <input type="text" name="key" class="form-control" placeholder="Search..." value="{{request('key')}}">
                                <button class="btn bg-light text-dark" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-1 offset-10 bg-white shadow-sm p-2 my-1 text-center">
                        <h3> <i class="fa-solid fa-database"></i> - {{ count($contact) }}</h3>
                    </div>
                </div>

                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Contact ID</th>
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>Created At</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($contact as $c)
                            <tr class="tr-shadow">
                                <input type="hidden" class="orderId" value="{{$c->id}}">
                                <td>{{$c->id}}</td>
                                <td>{{$c->name}}</td>
                                <td>{{$c->email}}</td>
                                <td>{{$c->created_at->format("j F Y")}}</td>
                                <td class="pr-2">
                                    <a href="{{route('admin#userContactInfo', $c->id)}}">
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="User's Message">
                                            <i class="fa-solid fa-circle-info fa-xl"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{$contact->links()}}
                    </div>
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
@endsection
