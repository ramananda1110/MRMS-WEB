@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center rounded shadow p-3 mb-5 bg-white" style="background-color: white">
    <div class="col-md-11">
                @if(Session::has('message'))
                     <div class='alert alert-success'>
                          {{Session::get('message')}}
                      </div>
                @endif
           
                <form action="{{route('notices.store')}}" method="post">@csrf
                <div class="card mt-3 mb-3">
                    <div class="card-header">{{__('messages.createNotice')}} </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">{{__('messages.title')}} </label>
                            <input type="text" name="title" 
                            class="form-control @error('title') is-invalid @enderror">

                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                             @enderror
     
                        </div>
 
                        <div class="form-group mt-2">
                            <label>{{__('messages.description')}} </label>
                            <textarea type="text" name="description" 
                            class="form-control @error('description') is-invalid @enderror"></textarea>

                            @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        

                        </div>

                        <div class="form-group mt-2">
                            <label>{{__('messages.noticeDate')}} </label>
                            <input  name="date" 
                            class="form-control @error('date') is-invalid @enderror" placeholder="dd-mm-yyyy" id="datepicker">

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
                          <button class="btn btn-outline-primary">{{__('messages.submit')}} </button>
                       </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
