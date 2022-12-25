@extends('admin.layouts.master')

@section('title', 'Orders')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">

                @if(session('deleteSuccess'))
                <div class="col-4 offset-8">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i> {{session('deleteSuccess')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                </div>
                @endif
                <!-- DATA TABLE -->
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
                                <th>Role</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="col-3">
                                        @if ($user->image == null)
                                            @if ($user->gender == 'Male')
                                                <img src="{{ asset('image/default_user.png') }}" class="img-thumbnail shadow-sm w-50" alt="Default User Image">
                                            @else
                                                <img src="{{ asset('image/female_default.png') }}" class="img-thumbnail shadow-sm w-50" alt="Default User Image">
                                            @endif
                                        @else
                                            <img src="{{asset('storage/'.$user->image)}}" class="img-thumbnail shadow-sm w-50"/>
                                        @endif
                                    </td>
                                    <input type="hidden" id="userId" value="{{$user->id}}">
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->gender}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user->address}}</td>
                                    <td class="col-2">
                                        <select class="form-control statusChange rounded">
                                            <option value="user" @if ($user->role == 'user') selected @endif> User </option>
                                            <option value="admin" @if ($user->role == 'admin') selected @endif> Admin </option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="{{route('admin#userDelete', $user->id)}}">
                                            <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa-solid fa-trash me-1"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3 px-3">
                        {{$users->links()}}
                    </div>
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
                url : '/admin/ajax/changeRole',
                data : $data,
                dataType : 'json',
            });

            location.reload();
        });
        // $.ajax({
        //     type : 'get',
        //     url : '/user/ajax/pizza/list',
        //     data :
        //     dataType : 'json',
        //     success :  function(response){
        //         console.log(response)
        //     }
        // });
    });
</script>
@endsection
