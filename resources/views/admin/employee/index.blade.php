@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
    @endif
    
    <div class="row justify-content-center">
        <div class="col-md-11">
                <div class="card-body">
                    <form action="{{route('import.excel')}}" method="POST", enctype="multipart/form-data">@csrf        
 
                    <div class="input-group"> 
                        <input type="file" name="file"  placeholder="attached xlsx" class="form-control">

                        <button class="btn btn-outline-primary">Import</button>

                    </div>
                    </form>

                    <div class="form-group mt-5">
                    </div>
                </div>
           

        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">List Of Employee</li>
            </ol>
        </nav>

        <div class="card-body">
            <table id="employeeTable" class="table table-striped table-bordered">
            
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Name</th>
                   
                    <th scope="col">Division</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Project</th>
                    <th scope="col">Action</th>
                   
                    </tr>
                </thead>
                <tbody>

                    @if(count($employees)>0)
                          @foreach($employees as
                          $key=>$employee)
                   
                    <tr>
                    <th scope="row">{{$key+1}}</th>
                    <th scope="row">{{$employee->employee_id}}</th>
                    <td>{{$employee->name}}</td>
                    
                    <td>{{$employee->division}}</td>
                    <td>{{$employee->designation}}</td>
                    <td>{{$employee->project}}</td>
                    
                    <td> 
                         @if(isset(Auth()->user()->role->permission['name']['department']['can-edit']))
                                <a style="margin-right: 5px;" href="{{route('departments.edit',
                                    [$employee->id])}}">
                                 <i class="fas fa-edit"></i></a> 
                                <!-- </td> -->
                            
                                 @endif

                            <!-- <td> -->

                                 @if(isset(Auth()->user()->role->permission['name']['department']['can-delete']))
                                  
                                <!-- Button trigger modal -->
                                <a   data-bs-toggle="modal" data-bs-target="#exampleModal{{$employee->id}}", href="#">
                                  <i class="fas fa-trash"></i>
                                </a>
                                @endif
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$employee->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete!</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                       
                                        Are you sure? do you want to delete item?


                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form action="{{route('departments.destroy',
                                                        [$employee->id])}}" method="post">@csrf
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
                    
                    <p> No user found!</p>
                    
                            @endif
                </tbody>
            </table>
            
            {{$employees->links('pagination::bootstrap-4')}}
        </div>
       
        </div>
        
     </div>
       
  
</div>
@endsection
