@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
     @endif
   
    
 <form action="{{route('import.excel')}}" method="POST", enctype="multipart/form-data">@csrf        
    <div class="row justify-content-center">
        <div class="col-md-10">
             <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">List Of Employee</li>
                 </ol>
             </nav>
            <div class="card">
                <div class="card-header">Import</div>

                <div class="card-body">
                    
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" name="file"  
                        class="form-control">

                    </div>
                

                    <div class="form-group mt-5">
                        <button class="btn btn-outline-primary">Submit</button>
                    </div>
                </div>
            </div>
        
        </div>
       
    </form>
</div>
@endsection
