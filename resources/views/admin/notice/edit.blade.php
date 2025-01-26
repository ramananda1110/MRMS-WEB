@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
                @if(Session::has('message'))
                     <div class='alert alert-success'>
                          {{Session::get('message')}}
                      </div>
                @endif
           
                <form action="{{route('notices.update', [$notice->id])}}" method="post">@csrf
                    {{method_field('PATCH')}}
                <div class="card">
                    <div class="card-header">Update Notice</div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" 
                            class="form-control @error('title') is-invalid @enderror" value="{{$notice->title}}">

                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                             @enderror
     
                        </div>
 
                        <div class="form-group mt-2">
                            <label>{{__('messages.description')}} </label>
                            <textarea type="text" name="description"  
                            class="form-control @error('description') is-invalid @enderror">{{$notice->description}}</textarea>

                            @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        

                        </div>

                        <div class="form-group mt-2">
                            <label>{{__('messages.noticeDate')}} </label>
                            <input  name="date" 
                            class="form-control @error('date') is-invalid @enderror"  value="{{$notice->date}}"
                            placeholder="dd-mm-yyyy" id="datepicker">

                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
    
                        </div>

                        <div class="form-group mt-2">
                            <label for="name">{{__('messages.createdBy')}} </label>
                            <input type="text" name="name" value="{{auth()->user()->name}}"
                            class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                             @enderror
     
                        </div>

                        <div class="form-group mt-5">
                        @if(isset(Auth()->user()->role->permission['name']['notice']['can-edit']))
                               
                          <button class="btn btn-outline-primary">{{__('messages.update')}} </button>
                         @endif 
                       </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
