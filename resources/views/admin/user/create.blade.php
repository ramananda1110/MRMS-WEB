@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
     @endif
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Register Employee</li>
        </ol>
     </nav>
    
 <form action="{{route('users.store')}}" method="post", enctype="multipart/form-data">@csrf        
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">General Information</div>

                <div class="card-body">

                   
                    <div class="form-group">
                        <label>Project Code</label>
                        <input type="text" name="project_code" 
                        class="form-control" required="">
                    </div>

                    <div class="form-group mt-2">
                        <label>First Name</label>
                        <input type="text" name="firstname" 
                        class="form-control" required="">
                    </div>

                    <div class="form-group  mt-2">
                        <label>Last Name</label>
                        <input type="text" name="lastname" 
                        class="form-control" required="">

                    </div>

                    <div class="form-group  mt-2">
                        <label for="name">Email</label>
                        <input type="email" name="email" 
                        class="form-control" required="">

                    </div>

                    <div class="form-group  mt-2">
                        <label for="address">Address</label>
                        <input type="text" name="address" 
                        class="form-control" required="">
                    </div>

                    <div class="form-group  mt-2">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile_number" 
                        class="form-control" required="">
    
                    </div>

                    <div class="form-group  mt-2">
                        <label>Division</label>
                        <select class="form-control" name="department_id"
                        require="">
                            @foreach(App\Models\Department::all() as $department)
                            <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>


                    </div>
                    <div class="form-group  mt-2">
                        <label>Designation</label>
                        <input type="text" name="designation" 
                        class="form-control", required="">

                       
    
                    </div>

                    <div class="form-group  mt-2">
                        <label>Start Date</label>
                        <input  name="start_from" 
                        class="form-control" required="" placeholder="yy-mm-dd" id="datepicker">

                        @error('start_from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>
                
                    <div class="form-group  mt-2">
                        <label>Image</label>
                        <input type="file" name="image"  accept="image/*"
                        class="form-control">

                    </div>
                

                </div>
            </div>
        
        </div>
        <div class="col-md-4">
        <div class="card">
            <div class="card-header">Login Information</div>

                <div class="card-body">
                   

                    <div class="form-group">
                        <label>Employee ID</label>
                        <input type="text" name="employee_id" 
                        class="form-control" required="">
                    </div>

                    <div class="form-group  mt-2">
                        <label for="name">Password</label>
                        <input type="password" name="password" 
                        class="form-control" required="">
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

                    <div class="form-group mt-3">
                        <button class="btn btn-outline-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </form>
</div>
@endsection
