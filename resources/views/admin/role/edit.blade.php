@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form action="{{route('roles.update', [$role->id])}}" method="post">@csrf
            {{method_field('PATCH')}}
                <div class="card">
                    <div class="card-header">{{__('messages.updateRole')}} </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{__('messages.name')}} </label>
                            <input type="text" name="name" 
                            class="form-control @error('name') is-invalid @enderror" value="{{$role->name}}">

                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                             @enderror
     
                        </div>


                    
                        <div class="form-group mt-2">
                            <label>{{__('messages.description')}} </label>
                            <textarea type="text" name="description" class="form-control mt-1 @error('description') is-invalid @enderror"> {{$role->description}}</textarea>

                            @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        

                        </div>
                    

                        <div class="form-group mt-3">
                             @if(isset(Auth()->user()->role->permission['name']['role']['can-edit']))

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
