@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
       
    @endif
    @if(Session::has('error'))
    <div class='alert alert-danger'>
        {{ Session::get('error') }}
    </div>
    @endif
    
    <div class="row justify-content-center px-2 py-2 rounded shadow p-3 mb-5 bg-white" style="background-color: white">
    
            
                {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"> --}}
                        {{-- <div > --}}
                            <div class="card ms-4 mt-3 me-4" style="border-bottom: 1px solid silver;">
                                <div class="panel-heading no-print mt-2 mb-2">
                                    <div class="btn-group">
                                        <a href="{{Route('employee.create')}}" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> Add Employee
                                        </a>                           
                                    </div>  
                                </div>
                            </div>
                            

                            <div class="row mb-3 mt-3">

                                <div class="col-sm-4">
                                    <form action="{{route('import.excel')}}" method="POST", enctype="multipart/form-data">@csrf        
                    
                                    <div class="input-group mt-2"> 
                                        <input type="file" name="file"  placeholder="attached xlsx" class="form-control">
                    
                                        <button class="btn btn-outline-primary">Import</button>
                    
                                    </div>
                                    </form>
                    
                                    
                                </div>
                              

                            

                                <div class="col-sm-4 text-center mt-2">

                                    <form action="{{route('employee.download-pdf')}}" method="post", target="_blank">@csrf        

                                    <div class="form-group mt-3">
                                            <button class="btn btn-outline-primary">pdf</button>
                                         </div>
                

                                    </form>

                                    <form action="{{route('employee.download-excel')}}" method="post", target="_blank">@csrf        

                                    <div class="form-group mt-3">
                                            <button class="btn btn-outline-primary">Excel</button>
                                        </div>


                                    </form>


                                    <div class="dt-buttons btn-group border">
                                    
                                        <a class="btn btn-default buttons-csv border buttons-html5 btn-sm" tabindex="0" aria-controls="employees">
                                            <span>csv</span>
                                        </a>
                                        <a class="btn btn-default buttons-excel border buttons-html5 btn-sm" tabindex="0" aria-controls="employees">
                                            <span>Excel</span>
                                        </a>
                                        <a class="btn btn-default buttons-pdf border buttons-html5 btn-sm" tabindex="0" aria-controls="employees">
                                            <span>PDF</span>
                                        </a>
                                        <a class="btn btn-default buttons-print border buttons-html5 btn-sm" tabindex="0" aria-controls="employees">
                                            <span>Print</span>
                                        </a>
                                    </div>
                                </div>


                                <div class="col-sm-4 mt-2">
                                    <form action="{{route('search.employee')}}" method="GET" class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="name,phone,emp id...">
                                        <div class="input-group-append ms-1">
                                            <button type="submit" class="btn btn-outline-primary">Search</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
              
                        {{-- <div class="col-md-3">
                            <span>List Of Employee:</span>
                        </div>
                            <div class="col-md-9">
                                <form action="{{route('search.employee')}}" method="GET" class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="name,phone,emp id...">
                                    <div class="input-group-append ms-1">
                                        <button type="submit" class="btn btn-outline-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div> --}}
                     {{-- </li>
                    </ol>
                </nav> --}}

        <div class="card-body" >
            <table  id="employeeTable"  class="table table-striped table-bordered datatable" >
            
                <thead>
                    <tr>
                    
                    <th scope="col">Employee ID</th>
                    <th scope="col">Name</th>
                    <!-- <th scope="col">Project Name</th> -->
                    <!-- <th scope="col">Project Code</th> -->
                    
                    <th scope="col">Division</th>
                    <!-- <th scope="col">Designation</th> -->
                    <th scope="col">Mobile</th>
                    <th scope="col">Email</th>
                    <!-- <th scope="col">Status</th> -->
                    <th scope="col">Action</th>
                   
                    </tr>
                </thead>
                <tbody>

                    @if(count($employees)>0)
                          @foreach($employees as
                          $key=>$employee)
                   
                    <tr>
                   
                        <th scope="row">{{$employee->employee_id}}</th>
                        <td>{{$employee->name}}</td>
                        <!-- <td>{{$employee->project_name}}</td> -->
                        <!-- <td>{{$employee->project_code}}</td> -->
                    
                        <td>{{$employee->division}}</td>
                        <!-- <td>{{$employee->designation}}</td> -->
                        <td>{{$employee->mobile_number}}</td>
                        <td>{{$employee->email}}</td>
                        <!-- <td>{{$employee->status}}</td> -->
                        
                   
                     <td> 
                        
                                <a  href="{{route('employee.edit',[$employee->id])}}">
                                <i class="fas fa-edit"></i></a> 
                                <!-- </td> -->
                            
                                
                            

                                <!-- <td> -->

<!-- <i class="fas fa-trash"></i> -->
                                  
                                <!-- Button trigger modal -->
                                <a data-bs-toggle="modal" data-bs-target="#exampleModal{{$employee->id}}", href="#">
                                <i class="fas fa-trash" style="margin-left: 10;"></i></a>
                             
                                <!-- </i> -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2{{$employee->id}}">
                                     <i class="fa-solid fa-user-plus" style="margin-left: 10;"></i></a>
                                
                           
                        
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
                                        <form action="{{route('employee.destroy',
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


                                <div class="modal fade" id="exampleModal2{{$employee->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{route('create.user', [$employee->id])}}" method="post">@csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Create a User</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                
                                                <div class="card">
                                               
                                                <div class="card-body">
                                                

                                                <div class="form-group">
                                                    <label>Division</label>
                                                    <select class="form-control" name="department_id"
                                                    require="">
                                                        @foreach(App\Models\Department::all() as $department)
                                                        <option value="{{$department->id}}" @if($department->name==$employee->division)
                                                            selected @endif>
                                                            {{$department->name}}

                                                        </option>
                                                        @endforeach
                                                    </select>


                                                </div>
                                                            
                                                    <div class="form-group  mt-2">
                                                        <label>Role</label>
                                                        <select class="form-control" name="role_id"
                                                        require="">
                                                            @foreach(App\Models\Role::all() as $role)
                                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>


                                                    <div class="form-group  mt-2">
                                                        <label for="name">Password</label>
                                                        <input type="password" name="password" 
                                                        class="form-control" required="">
                                                    </div>


                                                </div>
                                                
                                            </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <form action="#" method="post">@csrf
                                                        
                                                            <button class="btn btn-outline-success">
                                                                Create
                                                            </button>
                                                </form>
                                                </div>
                                            </div>
                                        </form>
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
@endsection


