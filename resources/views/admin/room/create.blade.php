@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
     @endif
 
    
 <form action="{{route('rooms.store')}}" method="post", enctype="multipart/form-data">@csrf        
    <div class="row justify-content-center rounded shadow p-3 mb-5 bg-white" style="background-color: white">

        <div class="col-md-11">
       
        <div class="card mt-3 mb-3">
            
                <div class="card-header">Create a Room</div>

                <div class="card-body">
                    <div class="form-group">
                        <label>Room Name</label>
                        <input  name="name" 
                        class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>Location</label>
                        <input  name="location" 
                        class="form-control form-control @error('location') is-invalid @enderror">

                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>To capacity</label>
                        <input  name="capacity" type="number" placeholder="10"
                        class="form-control form-control @error('capacity') is-invalid @enderror">

                        @error('capacity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                        
                
                    <div class="form-group mt-2">
                    <label for="description">Facilities</label>
                    <textarea class="form-control form-control @error('facilities') is-invalid @enderror" name="facilities" placeholder="Projector, white board, wiper, marker etc" rows="3"></textarea>
                    @error('facilities')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
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
