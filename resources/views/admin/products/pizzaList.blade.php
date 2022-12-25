@extends('admin.layouts.master')

@section('title', 'Product List')

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
                            <h2 class="title-1">Product List</h2>

                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <a href="{{route('products#createPage')}}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>Add Product
                            </button>
                        </a>
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button>
                    </div>
                </div>

                @if(session('deleteSuccess'))
                <div class="col-4 offset-8">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i> {{session('deleteSuccess')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-4">
                        <h4 class="text-secondary">Search Key: <span class="text-info">{{request('key')}}</span></h4>
                    </div>
                    <div class="col-3 offset-5">
                        <form action="{{route('products#list')}}" method="get">
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
                        <h3> <i class="fa-solid fa-database"></i> {{ $pizzas->total() }}</h3>
                    </div>
                </div>

                @if (count($pizzas) != 0)
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Product Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>View Count</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pizzas as $p)
                            <tr class="tr-shadow">
                                <td class="w-25"><img src="{{ asset('storage/'.$p->image) }}" class="img-thumbnail shadow-sm"></td>
                                <td>{{$p->name}}</td>
                                <td>{{$p->price}}</td>
                                <td>{{$p->category_name}}</td>
                                <td><i class="fa-solid fa-eye"></i> {{$p->view_count}}</td>
                                <td>
                                    <div class="table-data-feature">
                                        <a href="{{route('products#details', $p->id)}}" class="mx-1">
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Info">
                                                <i class="fa-solid fa-info"></i>
                                            </button>
                                        </a>

                                        <a href="{{route('products#editPage', $p->id)}}" class="mx-1">
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </button>
                                        </a>

                                        <a href="{{route('products#delete', $p->id)}}" class="mx-1">
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </a>
                                        {{-- <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                            <i class="zmdi zmdi-more"></i>
                                        </button> --}}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{$pizzas->links()}}
                    </div>
                </div>
                @else
                <h3 class="text-secondary text-center mt-5">There is no Product here</h3>
                @endif
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
@endsection
