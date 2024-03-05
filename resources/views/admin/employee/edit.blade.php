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
            <li class="breadcrumb-item active" aria-current="page">Update</li>
        </ol>
     </nav>
    
     <form action="{{route('employee.update', [$employee->id])}}" method="post">@csrf
            {{method_field('PATCH')}}

    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Update an Employee</div>

                <div class="card-body">

                    <div class="form-group">
                        <label>Employee ID</label>
                        <input type="text" name="employee_id"  value = "{{$employee->employee_id}}"
                     class="form-control @error('employee_id') is-invalid @enderror">

                        @error('employee_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Project Code</label>
                        <input type="text" name="project_code" value = "{{$employee->project_code}}"
                        class="form-control" required="">
                    </div>

                    <div class="form-group mt-2">
                        <label>Emplyee Name</label>
                        <input type="text" name="name" value = "{{$employee->name}}"
                        class="form-control" required="">
                    </div>

                   
                    <div class="form-group  mt-2">
                        <label for="name">Email</label>
                        <input type="email" name="email"  value = "{{$employee->email}}"
                        class="form-control" required="">

                    </div>

                    <div class="form-group  mt-2">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile_number"  value = "{{$employee->mobile_number}}"
                        class="form-control" required="">
    
                    </div>

                  
                    <div class="form-group">
                        <label>Grade</label>
                        <input type="text" name="grade" value = "{{$employee->grade}}"
                        class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label>Project Name</label>
                        <input type="text" name="project_name" value = "{{$employee->project_name}}"
                        class="form-control" required="">
                    </div>

                    <div class="form-group">
                        <label>Division</label>
                        <select class="form-control" name="division"
                        require="">
                            @foreach(App\Models\Department::all() as $department)
                            <option value="{{$department->name}}" @if($department->name==$employee->division)
                                selected @endif>
                                {{$department->name}}

                            </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group  mt-2">
                        <label>Designation</label>
                        <input type="text" name="designation" value = "{{$employee->designation}}"
                        class="form-control", required="">

    
                    </div>
                   
                    <div class="form-group mt-3">
                        <button class="btn btn-outline-primary">Update</button>
                    </div>
                

                </div>
            </div>
        
        </div>
    
      </div>
    </form>
</div>
@endsection
