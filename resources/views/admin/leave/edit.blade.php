@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
     @endif
 
    
 <form action="{{route('leaves.update', [$leave->id])}}" method="post">@csrf    
    {{method_field('PATCH')}}    
    <div class="row justify-content-center">
    
        <div class="col-md-10">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">{{__('messages.leaveForm')}} </li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header">{{__('messages.updateLeave')}} </div>

                <div class="card-body">
                    <div class="form-group">
                        <label>{{__('messages.dateFrom')}} </label>
                        <input  name="from" 
                        class="form-control @error('from') is-invalid @enderror" value="{{$leave->from}}" placeholder="dd-mm-yyyy" id="datepicker">

                        @error('from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>{{__('messages.dateTo')}} </label>
                        <input  name="to" 
                        class="form-control form-control @error('to') is-invalid @enderror" 
                        value="{{$leave->to}}" placeholder="yy-mm-dd" id="datepicker1">

                        @error('to')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>{{__('messages.leaveType')}} </label>
                        <select class="form-control" name="type">
                            <option value="annualeave">{{__('messages.annualLeave')}} </option>
                      
                            <option value="sickleave">{{__('messages.sickLeave')}} </option>
                        
                            <option value="parental">{{__('messages.parentalLeave')}} </option>
                            <option value="other">{{__('messages.otherLeave')}} </option>
                        </select>
                   
                        <div class="form-group mt-2">
                            <label for="description">{{__('messages.description')}} </label>
                            <textarea class="form-control form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{$leave->description}}</textarea>
                            @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    <div class="form-group mt-3">
                        <button class="btn btn-outline-primary">{{__('messages.update')}} </button>
                    </div>
                </div>
            </div>
        </div>
      </div>
 </form>

  

</div>
@endsection
