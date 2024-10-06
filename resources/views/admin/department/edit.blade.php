@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center rounded shadow p-3 mb-5 bg-white" style="background-color: white">

        <div class="col-md-11">
            <form action="{{route('departments.update', [$department->id])}}" method="post">@csrf
            {{method_field('PATCH')}}
                <div class="card mt-3 mb-3">
                    <div class="card-header">Update Department</div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" 
                            class="form-control @error('name') is-invalid @enderror" value="{{$department->name}}">

                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                             @enderror
     
                        </div>


                       
                        <div class="form-group mt-2">
                            <label>Description</label>
                            <textarea type="text" name="description" class="form-control @error('description') is-invalid @enderror">{{$department->description}}</textarea>

                            @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        

                        </div>
                    

                        <div class="form-group mt-3">
                            @if(isset(Auth()->user()->role->permission['name']['department']['can-edit']))

                             <button class="btn btn-outline-primary">Update</button>
                             @endif
                       </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
