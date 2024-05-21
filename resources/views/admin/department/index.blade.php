@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center rounded shadow p-3 mb-5 bg-white" style="background-color: white">
   
        <div class="col-md-10">

            <!-- <div class="card-body">
                <form action="{{route('import.excel')}}" method="POST", enctype="multipart/form-data">@csrf        

                <div class="input-group"> 
                    <input type="file" name="file"  placeholder="attached xlsx" class="form-control">

                    <button class="btn btn-outline-primary">Import</button>

                </div>
                </form>

                <div class="form-group mt-5">
                </div>
            </div> -->

            <div class="card mt-3" style="border-bottom: 1px solid silver;">
                <div class="panel-heading no-print mt-2 mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="ms-3">
                            <a href="{{ Route('departments.create') }}"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add Department</button></a>
                        </div>
                        <div class="btn-group d-flex justify-content-center align-items-center me-3">
                            <div class="row gx-0">
                                <div class="col-md">
                                    <form action="#" method="post" target="_blank">
                                        @csrf        
                                        <button type="submit" class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block" tabindex="0" aria-controls="employees">
                                            <span>csv</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md">
                                    <form action="#" method="post" target="_blank">
                                        @csrf        
                                        <button class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block">Excel</button>
                                    </form>
                                </div>
                                <div class="col-md">
                                    <form action="#" method="get" target="_blank">
                                        @csrf        
                                        <button class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block">Pdf</button>
                                    </form>
                                </div>
                                <div class="col-md">
                                    <a class="btn btn-default buttons-print border buttons-html5 btn-sm btn-block" tabindex="0" aria-controls="employees">
                                        <span>Print</span>
                                    </a>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-2">
                    <li class="breadcrumb-item active" aria-current="page">All Departments</li>
                </ol>
            </nav>
            @if(Session::has('message'))
                     <div class='alert alert-success'>
                          {{Session::get('message')}}
                      </div>
            @endif
           
            <table id="table ", class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if(count($departments)>0)
                          @foreach($departments as
                          $key=>$department)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$department->name}}</td>
                            <td>{{$department->description}}</td>
                           
                            <td> 
                                @if(isset(Auth()->user()->role->permission['name']['department']['can-edit']))
                                <a style="margin-right: 5px;" href="{{route('departments.edit',
                                    [$department->id])}}">
                                 <i class="fas fa-edit"></i></a> 
                                <!-- </td> -->
                            
                                 @endif

                            <!-- <td> -->

                                 @if(isset(Auth()->user()->role->permission['name']['department']['can-delete']))
                                  
                                <!-- Button trigger modal -->
                                <a   data-bs-toggle="modal" data-bs-target="#exampleModal{{$department->id}}", href="#">
                                  <i class="fas fa-trash"></i>
                                </a>
                                @endif
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$department->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete!</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <!-- {{$department->id}} -->
                                        Are you sure? do you want to delete item?


                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form action="{{route('departments.destroy',
                                                        [$department->id])}}" method="post">@csrf
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
