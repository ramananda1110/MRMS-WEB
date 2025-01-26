@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
     @endif
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">{{__('messages.registerEmp')}} </li>
        </ol>
     </nav>
    
 <form action="{{route('users.store')}}" method="post", enctype="multipart/form-data">@csrf        
    <div class="row justify-content-center rounded shadow p-3 mb-5 bg-white" style="background-color: white">

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('messages.genInfo')}} </div>

                <div class="card-body">

                   
                    <div class="form-group">
                        <label>{{__('messages.projectCode')}} </label>
                        <input type="text" name="project_code" 
                        class="form-control" required="">
                    </div>

                    <div class="form-group mt-2">
                        <label>{{__('messages.firstName')}} </label>
                        <input type="text" name="firstname" 
                        class="form-control" required="">
                    </div>

                    <div class="form-group  mt-2">
                        <label>{{__('messages.lastName')}} </label>
                        <input type="text" name="lastname" 
                        class="form-control" required="">

                    </div>

                    <div class="form-group  mt-2">
                        <label for="name">{{__('messages.email')}} </label>
                        <input type="email" name="email" 
                        class="form-control" required="">

                    </div>

                    <div class="form-group  mt-2">
                        <label for="address">{{__('messages.address')}} </label>
                        <input type="text" name="address" 
                        class="form-control" required="">
                    </div>

                    <div class="form-group  mt-2">
                        <label>{{__('messages.mobile')}} </label>
                        <input type="text" name="mobile_number" 
                        class="form-control" required="">
    
                    </div>

                    <div class="form-group  mt-2">
                        <label>{{__('messages.division')}} </label>
                        <select class="form-control" name="department_id"
                        require="">
                            @foreach(App\Models\Department::all() as $department)
                            <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>


                    </div>
                    <div class="form-group  mt-2">
                        <label>{{__('messages.designation')}} </label>
                        <input type="text" name="designation" 
                        class="form-control", required="">

                       
    
                    </div>

                    <div class="form-group  mt-2">
                        <label>{{__('messages.joiningDate')}} </label>
                        <input  name="start_from" 
                        class="form-control" required="" placeholder="yy-mm-dd" id="datepicker">

                        @error('start_from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>
                
                    <div class="form-group  mt-2">
                        <label>{{__('messages.image')}} </label>
                        <input type="file" name="image"  accept="image/*"
                        class="form-control">

                    </div>
                

                </div>
            </div>
        
        </div>
        <div class="col-md-4">
        <div class="card">
            <div class="card-header">{{__('messages.loginInformation')}} </div>

                <div class="card-body">
                   

                    <div class="form-group">
                        <label>{{__('messages.empId')}} </label>
                        <input type="text" name="employee_id" 
                        class="form-control" required="">
                    </div>

                    <div class="form-group  mt-2">
                        <label for="name">{{__('messages.password')}} </label>
                        <input type="password" name="password" 
                        class="form-control" required="">
                    </div>

                    <div class="form-group  mt-2">
                        <label>{{__('messages.role')}} </label>
                        <select class="form-control" name="role_id"
                        require="">
                            @foreach(App\Models\Role::all() as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group mt-3">
                        <button class="btn btn-outline-primary">{{__('messages.submit')}} </button>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </form>
</div>
@endsection
