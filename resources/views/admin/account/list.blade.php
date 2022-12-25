@extends('admin.layouts.master')

@section('title', 'Admin Accounts')

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
                            <h2 class="title-1">Admin List</h2>

                        </div>
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
                        <form action="{{route('admin#list')}}" method="get">
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
                        <h3> <i class="fa-solid fa-database"></i> - {{$admin->total()}}</h3>
                    </div>
                </div>

                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Change Role</th>
                                <th>Delete Account</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admin as $a)
                            <tr class="tr-shadow">
                                <td class="col-2">
                                    @if ($a->image == null)
                                        @if ($a->gender == 'Male')
                                            <img src="{{ asset('image/default_user.png') }}" class="img-thumbnail shadow-sm" alt="Default User Image">
                                        @else
                                            <img src="{{ asset('image/female_default.png') }}" class="img-thumbnail shadow-sm" alt="Default User Image">
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/'.$a->image) }}" class="img-thumbnail shadow-sm">
                                    @endif
                                </td>
                                <input type="hidden" id="userId" value="{{$a->id}}">
                                <td class="col-1">{{ $a->name }}</td>
                                <td class="col-2">{{ $a->email }}</td>
                                <td class="col-1">{{ $a->gender }}</td>
                                <td class="col-1">{{ $a->phone }}</td>
                                <td class="col-2">{{ $a->address }}</td>
                                <td class="col-2">
                                    <div class="table-data-feature">
                                        @if ( Auth::user()->id == $a->id )

                                        @else
                                        <select class="form-control statusChange rounded">
                                            <option value="user" @if ($a->role == 'user') selected @endif> User </option>
                                            <option value="admin" @if ($a->role == 'admin') selected @endif> Admin </option>
                                        </select>
                                        @endif
                                    </div>
                                </td>
                                <td class="col-1">
                                    <div class="table-data-feature">
                                        @if ( Auth::user()->id == $a->id )

                                        @else
                                            <a href="{{route('admin#delete', $a->id)}}">
                                                <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="fa-solid fa-trash me-1"></i>
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{$admin->links()}}
                    </div>

                    <!-- Button trigger modal -->
                    {{-- <td>
                        <div class="table-data-feature">
                            @if ( Auth::user()->id == $a->id )

                            @else
                                <a href="{{route('admin#changeRole', $a->id)}}">
                                    <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Change Role">
                                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                    </button>
                                </a>
                            <a href="{{route('admin#delete', $a->id)}}">
                                <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fa-solid fa-trash me-1"></i>
                                </button>
                            </a>
                            @endif
                        </div>
                    </td> --}}
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Launch demo modal
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              ...
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div> --}}
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptSource')
<script>
    $(document).ready(function(){

        $('.statusChange').change(function(){
            $currentStatus = $(this).val();
            $parentNode = $(this).parents("tr");
            $userId = $parentNode.find('#userId').val();

            $data = {
                'userId' : $userId,
                'role' : $currentStatus,
            }

            console.log($data);

            $.ajax({
                type : 'get',
                url : '/admin/user/changeRole',
                data : $data,
                dataType : 'json',
            });

            location.reload();
        });
        // $.ajax({
        //     type : 'get',
        //     url : 'http://127.0.0.1:8000/user/ajax/pizza/list',
        //     data :
        //     dataType : 'json',
        //     success :  function(response){
        //         console.log(response)
        //     }
        // });
    });
</script>
@endsection
