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
    
        <div class="col-md-10">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">{{__('messages.leaveForm')}} </li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header">{{__('messages.createLeave')}} </div>

                <div class="card-body">
                    <div class="form-group">
                        <label>{{__('messages.dateFrom')}} </label>
                        <input  name="from" 
                        class="form-control @error('from') is-invalid @enderror" placeholder="dd-mm-yyyy" id="datepicker">

                        @error('from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
    
                    </div>

                    <div class="form-group mt-2">
                        <label>{{__('messages.dateTo')}} </label>
                        <input  name="to" 
                        class="form-control form-control @error('to') is-invalid @enderror"  placeholder="yy-mm-dd" id="datepicker1">

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
                            <textarea class="form-control form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3"></textarea>
                            @error('description')
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

    {{-- <div class="col-md-10 mt-3">
        
        <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date from</th>
                    <th scope="col">Date to</th>
                    <th scope="col">Description</th>
                    <th scope="col">Type</th>
                    <th scope="col">Replay</th>
                    <th scope="col">Status</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaves as $leave)
                    <tr>
                    <th scope="row">1</th>
                    <td>{{$leave->from}}</td>
                    <td>{{$leave->to}}</td>
                    <td>{{$leave->description}}</td>
                    <td>{{$leave->type}}</td>
                    <td>{{$leave->message}}</td>
                    <td>
                        @if($leave->status=='0') 
                        <span class="alert alert-danger"> pending</span>
                        @else 
                        <span class="alert alert-success"> Approved</span>

                        @endif
                    </td>

                    <td> 
                        
                        <a href="{{route('leaves.edit',
                            [$leave->id])}}">
                            <i class="fas fa-edit"></i></a> </td>
                    
                        

                    <td>

                    <!-- Button trigger modal -->
                    <a   data-bs-toggle="modal" data-bs-target="#exampleModal{{$leave->id}}", href="#">
                        <i class="fas fa-trash"></i>
                    </a>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete!</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            
                            Are you sure? do you want to delete item?


                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form action="{{route('leaves.destroy',
                                            [$leave->id])}}" method="post">@csrf
                                        {{method_field('DELETE')}}
                                        <button class="btn btn-outline-danger">
                                            Delete
                                        </button>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>

                    </tr>
                   
                    @endforeach
                   
                </tbody>
            </table>
    </div> --}}


</div>
@endsection
