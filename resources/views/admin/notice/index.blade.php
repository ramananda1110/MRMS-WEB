@extends('admin.layouts.master')

@section('content')
<div class="container mt-5 rounded shadow p-3 mb-5 bg-white" style="background-color: white">

    <div class="row justify-content-center">

    
   
        <div class="col-md-11">
            <div class="card mt-3" style="border-bottom: 1px solid silver;">
                <div class="panel-heading no-print mt-2 mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="ms-3">
                            <a href="{{ Route('notices.create') }}"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add Notice</button></a>
                        </div>
                        <div class="btn-group d-flex justify-content-center align-items-center me-3">
                            <div class="row gx-0">
                                <div class="col-md">
                                    <form action="#" method="post" target="_blank">
                                        @csrf        
                                        <button type="submit" class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block" tabindex="0" aria-controls="employees">
                                            <span>csv</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md">
                                    <form action="#" method="post" target="_blank">
                                        @csrf        
                                        <button class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block">Excel</button>
                                    </form>
                                </div>
                                <div class="col-md">
                                    <form action="#" method="get" target="_blank">
                                        @csrf        
                                        <button class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block">Pdf</button>
                                    </form>
                                </div>
                                <div class="col-md">
                                    <a class="btn btn-default buttons-print border buttons-html5 btn-sm btn-block" tabindex="0" aria-controls="employees">
                                        <span>Print</span>
                                    </a>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-2">
                    <li class="breadcrumb-item active" aria-current="page">All Notice</li>
                </ol>
            </nav>
            @if(Session::has('message'))
                     <div class='alert alert-success'>
                          {{Session::get('message')}}
                      </div>
            @endif
            @if(count($notices)>0)
            @foreach($notices as $notice)

            <div class="card alert alert-info">
                <div class="card-header alert alert-warning">{{$notice->title}}</div>
                <div class="card-body">
                    <p>{{$notice->description}}</p>
                    <p class="badge text-bg-success">Date: {{$notice->date}}</p>
                    <p class="badge text-bg-warning">Created By: {{$notice->name}}</p>
                </div>
                <div class="card-footer">
                     @if(isset(Auth()->user()->role->permission['name']['notice']['can-edit']))
                       
                    <a href="{{route('notices.edit', [$notice->id])}}">
                                 <i class="fas fa-edit"></i>
                    </a>
                    @endif
                    <span class="float-end">
                        <!-- Button trigger modal -->
                        @if(isset(Auth()->user()->role->permission['name']['notice']['can-delete']))
                    
                        <a   data-bs-toggle="modal" data-bs-target="#exampleModal{{$notice->id}}", href="#">
                                  <i class="fas fa-trash"></i>
                                </a>

                         @endif       
                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal{{$notice->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <form action="{{route('notices.destroy', [$notice->id])}}" method="post">@csrf
                                                    {{method_field('DELETE')}}
                                                    <button class="btn btn-outline-danger">
                                                        Delete
                                                    </button>
                                        </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                    </span>
                </div>
            </div> 

            @endforeach
          
           
            @else 
            <p>No notices created yet</p>

            @endif
        </div>
    
    </div>
</div>
@endsection
