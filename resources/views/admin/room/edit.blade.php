@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
     @endif
 
    
 <form action="{{route('rooms.update', [$room->id])}}" method="post", enctype="multipart/form-data">@csrf  
    {{method_field('PATCH')}}          
    <div class="row justify-content-center">
    
        <div class="col-md-10">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Create a Room</li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header"></div>

                <div class="card-body">
                    <div class="form-group">
                        <label>Room Name</label>
                        <input  name="name" 
                        class="form-control @error('name') is-invalid @enderror" value="{{$room->name}}">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>Location</label>
                        <input  name="location" 
                        class="form-control form-control @error('location') is-invalid @enderror" value="{{$room->location}}">

                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>To capacity</label>
                        <input  name="capacity" type="number" placeholder="10" value="{{$room->capacity}}"
                        class="form-control form-control @error('capacity') is-invalid @enderror">

                        @error('capacity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                        
                
                    <div class="form-group mt-2">
                    <label for="description">Facilities</label>
                    <textarea class="form-control form-control @error('facilities') is-invalid @enderror" name="facilities" placeholder="Projector, white board, wiper, marker etc" rows="3">{{$room->facilities}}</textarea>
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
