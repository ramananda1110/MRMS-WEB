@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Send Email</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <form action="{{route('mails.store')}}" method="post", enctype="multipart/form-data">@csrf        
                <div class="row justify-content-center">
                    
                    <div class="form-group mt-2">
                        <label>Select</Select></label>
                        <select class="form-control" name="mail" id="mail">
                            <option value="0">mail to all staff</option>
                      
                            <option value="1">choose department</option>
                        
                            <option value="2">choose person</option>
                            
                        </select>
                        <br>

                        <select class="form-control" name="department" id="department">
                            
                            @foreach(App\Models\Department::all() as $department)
                            
                            <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                                
                        </select>


                        <select class="form-control" name="person" id="person">
                            
                            @foreach(App\Models\User::all() as $user)
                            
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                            
                        </select>

                        <br>

                        <div class="form-group mt-2">
                            <label>Body</label>
                            <textarea type="text" name="body"  
                            class="form-control @error('body') is-invalid @enderror"></textarea>

                            @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        

                        </div>
                   

                        <div class="form-group mt-2">
                            <label>File</label>
                            <input type="file" name="file"  
                            class="form-control @error('file') is-invalid @enderror">

                            @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        

                        </div>
                   
                       
                    <div class="form-group mt-3">
                        <button class="btn btn-outline-primary">Submit</button>
                    </div>
               
      
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    #department{
        display: none;
    }

    #person{
        display: none;
    }
</style>
@endsection
