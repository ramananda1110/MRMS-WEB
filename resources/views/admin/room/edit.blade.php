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
    <div class="row justify-content-center rounded shadow p-3 mb-5 bg-white" style="background-color: white">

    
        <div class="col-md-11">
       
        <div class="card mb-3 mt-3">
            <div class="card-header">{{__('messages.updateRoom')}} </div>

                <div class="card-body">
                    <div class="form-group">
                        <label>{{__('messages.roomName')}} </label>
                        <input  name="name" 
                        class="form-control @error('name') is-invalid @enderror" value="{{$room->name}}">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>{{__('messages.roomLocation')}} </label>
                        <input  name="location" 
                        class="form-control form-control @error('location') is-invalid @enderror" value="{{$room->location}}">

                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>{{__('messages.capacity')}} </label>
                        <input  name="capacity" type="number" placeholder="10" value="{{$room->capacity}}"
                        class="form-control form-control @error('capacity') is-invalid @enderror">

                        @error('capacity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                        
                
                    <div class="form-group mt-2">
                    <label for="description">{{__('messages.facilities')}} </label>
                    <textarea class="form-control form-control @error('facilities') is-invalid @enderror" name="facilities" placeholder="Projector, white board, wiper, marker etc" rows="3">{{$room->facilities}}</textarea>
                    @error('facilities')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
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
