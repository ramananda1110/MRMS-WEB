@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
     @endif
    
    
     <form action="{{route('employee.update', [$employee->id])}}" method="post">@csrf
            {{method_field('PATCH')}}

    <div class="row justify-content-center rounded shadow p-3 mb-5 bg-white" style="background-color: white">

        <div class="col-md-11">
            <div class="card mt-3 mb-3">
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
