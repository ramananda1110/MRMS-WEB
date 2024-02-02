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
                <li class="breadcrumb-item active" aria-current="page">Leave From</li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header">Update Leave</div>

                <div class="card-body">
                    <div class="form-group">
                        <label>From date</label>
                        <input  name="from" 
                        class="form-control @error('from') is-invalid @enderror" value="{{$leave->from}}" placeholder="dd-mm-yyyy" id="datepicker">

                        @error('from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>To date</label>
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
                        <label>Type of leave</label>
                        <select class="form-control" name="type">
                            <option value="annualeave">Annual Leave</option>
                      
                            <option value="sickleave">Sick Leave</option>
                        
                            <option value="parental">Parental Leave</option>
                            <option value="other">Other Leave</option>
                        </select>
                   
                        <div class="form-group mt-2">
                            <label for="description">Description</label>
                            <textarea class="form-control form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{$leave->description}}</textarea>
                            @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    <div class="form-group mt-3">
                        <button class="btn btn-outline-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
 </form>

  

</div>
@endsection
