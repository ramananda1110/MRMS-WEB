@extends('admin.layouts.master')

@section('content')
<div class="container mt-5 rounded shadow p-3 mb-5 bg-white" style="background-color: white">

    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
     @endif
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card mt-3" style="border-bottom: 1px solid silver;">
                <div class="panel-heading no-print mt-2 mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="ms-3">
                            <a href="{{ Route('permissions.create') }}"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add Permissions</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item active" aria-current="page">All Permissions</li>
                </ol>
            </nav>
           
            
            <table id="permissionTable" class="table table-striped table-bordered mt-2">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if(count($permissions)>0)
                          @foreach($permissions as
                          $key=>$permission)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$permission->role->name}}</td>
                           
                            <td>   @if(isset(Auth()->user()->role->permission['name']['permission']['can-edit']))
                                <a href="{{route('permissions.edit',
                                    [$permission->id])}}"><button type="button" class="btn btn-primary"><i class="fas fa-edit"></i></button></a> 
                                @endif
                            </td>
                            
                           <td>

                            <!-- Button trigger modal -->
                            @if(isset(Auth()->user()->role->permission['name']['permission']['can-delete']))
                                <a   data-bs-toggle="modal" data-bs-target="#exampleModal{{$permission->id}}", href="#">
                                    <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </a>
                            @endif
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$permission->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete!</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <!-- {{$permission->id}} -->
                                    Are you sure? do you want to delete item?

                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form action="{{route('permissions.destroy',
                                                    [$permission->id])}}" method="post">@csrf
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
                                <tr>
                                <td colspan="6" class="text-center">No Permissions to display</td>
                            </tr>
                        
                        @endif
                </tbody>
            </table>
        </div>
     </div>
</div>
@endsection
