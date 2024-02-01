@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row">
   
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">All Users</li>
                </ol>
            </nav>
            @if(Session::has('message'))
                     <div class='alert alert-success'>
                          {{Session::get('message')}}
                      </div>
            @endif
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Start Date</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Edit</th>
                        <th>Delete</th>  
                    </tr>
                </thead>
                
                <tbody>
                    @if(count($users)>0)
                          @foreach($users as
                          $key=>$user)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td><image src="{{asset('profile')}}//{{$user->image}}" width="50"></td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td><span class="badge bg-success">{{$user->role->name}}</span></td>
                            <td>{{$user->department->name}}</td>
                            <td>{{$user->designation}}</td>
                            <td>{{$user->start_from}}</td>
                            <td>{{$user->address}}</td>
                            <td>{{$user->mobile_number}}</td>
                           
                            <td> <a href="{{route('users.edit',
                                    [$user->id])}}">
                                 <i class="fas fa-edit"></i></a> </td>
                            

                            <td>

                                <!-- Button trigger modal -->
                                <a   data-bs-toggle="modal" data-bs-target="#exampleModal{{$user->id}}", href="#">
                                  <i class="fas fa-trash"></i>
                                </a>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete!</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <!-- {{$user->id}} -->
                                        Are you sure? do you want to delete item?


                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form action="{{route('users.destroy',
                                                        [$user->id])}}" method="post">@csrf
                                                    {{method_field('DELETE')}}
                                                    <button class="btn btn-outline-danger">
                                                        Delete
                                                    </button>
                                        </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                              </td>
                        </tr>
                    @endforeach
                     @else
                     
                        <td> No Department to display</td>
                       
                      @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
