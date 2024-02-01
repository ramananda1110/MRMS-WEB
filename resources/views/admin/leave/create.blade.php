@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
     @endif
 
    
 <form action="{{route('leaves.store')}}" method="post", enctype="multipart/form-data">@csrf        
    <div class="row justify-content-center">
    
        <div class="col-md-8">
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Leave From</li>
        </ol>
     </nav>
        <div class="card">
            <div class="card-header">Create Leave</div>

                <div class="card-body">
                    <div class="form-group">
                        <label>From date</label>
                        <input  name="from" 
                        class="form-control"  placeholder="dd-mm-yyyy" id="datepicker">

                        @error('from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>To date</label>
                        <input  name="to" 
                        class="form-control"  placeholder="yy-mm-dd" id="datepicker1">

                        @error('to')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>Type of leave</label>
                        <select class="form-control" name="type"
                        require="">
                            <option value="annualeave">Annual Leave</option>
                      
                            <option value="sickleave">Sick Leave</option>
                        
                            <option value="parental">Parental Leave</option>
                            <option value="other">Other Leave</option>
                        </select>
                   
                        <div class="form-group mt-2">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" rows="3"></textarea>
                        </div>
                    <div class="form-group mt-5">
                        <button class="btn btn-outline-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </form>
</div>
@endsection
