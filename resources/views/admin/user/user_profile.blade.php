@extends('admin.layouts.master')

@section('content')
    <form id="changepasswordform" action="{{ route('user.profile') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container mt-3">

            <div class="container  ">
                    <div class="container mt-3 py-5">
                        

                        <div class="row mt-3">
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                            alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                        <h5 class="my-3">{{$user->name}}</h5>
                                        <p class="text-muted mb-1">{{ $user->address }}</p>
                                        <p class="text-muted mb-4">{{ $user->email }}</p>
                                        
                                    </div>
                                </div>
                               
                            </div>
                            <div class="col-lg-8">
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Employee ID</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->employee->employee_id }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Full Name</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{$user->name}}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Designation</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->employee->designation }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Grade</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->employee->grade }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Project Code</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->employee->project_code }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Project Name</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->employee->project_name }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Email</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Mobile</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->mobile_number }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Division</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $user->employee->division }}</p>
                                            </div>
                                        </div>

                                        
                                        
                                    </div>
                                </div>
                                
                                   
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </form>
@endsection
