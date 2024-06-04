@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
                @if(Session::has('message'))
                     <div class='alert alert-success'>
                          {{Session::get('message')}}
                      </div>
                @endif
            <form action="{{route('departments.store')}}" method="post">@csrf
                <div class="card">
                    <div class="card-header">Department</div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" 
                            class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                             @enderror
     
                        </div>


                        
                        <div class="form-group mt-2">
                            <label>Description</label>
                            <textarea type="text" name="description" 
                            class="form-control @error('description') is-invalid @enderror"></textarea>

                            @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        

                        </div>
                    

                        <div class="form-group mt-5">
                          <button class="btn btn-outline-primary">Submit</button>
                       </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
