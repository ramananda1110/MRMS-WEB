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
            <li class="breadcrumb-item active" aria-current="page">Update Employee</li>
        </ol>
     </nav>
    
 <form action="{{route('users.update', [$user->id])}}" method="post", enctype="multipart/form-data">@csrf   
    {{method_field('PATCH')}}     
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">General Information</div>

                <div class="card-body">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" 
                        class="form-control" required="" value="{{$user->name}}">
                    </div>

                    

                    <div class="form-group">
                        <label">Address</label>
                        <input type="text" name="address" 
                        class="form-control" value="{{$user->address}}" required="">
                    </div>

                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile_number" 
                        class="form-control" value="{{$user->mobile_number}}" required="">
    
                    </div>

                    <div class="form-group">
                        <label>Department</label>
                        <select class="form-control" name="department_id"
                        require="">
                            @foreach(App\Models\Department::all() as $department)
                            <option value="{{$department->id}}" @if($department->id==$user->department_id)
                                selected @endif>
                                {{$department->name}}

                            </option>
                            @endforeach
                        </select>


                    </div>
                    <div class="form-group">
                        <label>Designation</label>
                        <input type="text" name="designation" 
                        class="form-control", value="{{$user->designation}}" required="">     
    
                    </div>

                    <div class="form-group">
                        <label>Start Date</label>
                        <input id="datepicker" name="start_from" 
                        class="form-control" value="{{$user->start_from}}" required="" placeholder="yy-mm-dd">

                        @error('start_from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>
                
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image"  accept="image/*" 
                        class="form-control", value="{{$user->image}}">

                    </div>
                

                </div>
            </div>
        
        </div>
        <div class="col-md-4">
        <div class="card">
            <div class="card-header">Login Information</div>

                <div class="card-body">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email"  value="{{$user->email}}"
                        class="form-control" required="">

                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" 
                        class="form-control" >
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="role_id"
                        require="">
                            @foreach(App\Models\Role::all() as $role)
                            <option value="{{$role->id}}" @if($role->id==$user->role_id)
                                selected @endif>
                                {{$role->name}}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group mt-5">

                         @if(isset(Auth()->user()->role->permission['name']['user']['can-edit']))

                        <button class="btn btn-outline-primary">Update</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
      </div>
    </form>
</div>
@endsection
