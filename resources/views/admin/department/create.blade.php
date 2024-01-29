@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form action="" methid="post>@csrf
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" 
                            class="form-control @error('name') is-invalid @enderro">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                             @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" name="description" 
                            class="form-control @error('description') is-invalid @enderro">
                            </textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group" style="margin-top: 10px;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
