@extends('admin.layouts.master')

@section('content')
<div class="container mt-5 rounded shadow p-3 mb-5 bg-white" style="background-color: white">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
     @endif
 
  <div class="row justify-content-center">
    
        <div class="col-md-10">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">{{__('messages.leaveList')}} </li>
            </ol>
        </nav>
    <div class="card">
        <table class="table">
                <thead>
                    <tr>
                    <th scope="col">{{__('messages.name')}} </th>
                    <th scope="col">{{__('messages.dateFrom')}} </th>
                    <th scope="col">{{__('messages.dateTo')}} </th>
                    <th scope="col">{{__('messages.description')}} </th>
                    <th scope="col">{{__('messages.type')}} </th>
                    <th scope="col">{{__('messages.replay')}} </th>
                    <th scope="col">{{__('messages.status')}} </th>
                   
                    <th scope="col">{{__('messages.approveOrReject')}} </th>
                    </tr>
                </thead>
                <tbody>
                
                    @foreach($leaves as $leave)
                    <tr>
                    <th scope="row">{{$leave->user->name}}</th>
                    <td>{{$leave->from}}</td>
                    <td>{{$leave->to}}</td>
                    <td>{{$leave->description}}</td>
                    <td>{{$leave->type}}</td>
                    <td>{{$leave->message}}</td>
                    <td>
                        @if($leave->status=='0') 
                        <span class="badge bg-danger">{{__('messages.pending')}} </span>
                        @else 
                        <span class="badge bg-success">{{__('messages.approved')}} </span>

                        @endif
                    </td>

                    <td>
                        <!-- Button trigger modal -->
                        <a data-bs-toggle="modal" data-bs-target="#exampleModal{{$leave->id}}", href="#">
                            {{__('messages.acceptOrReject')}}
                        </a>

                        <!-- <button type="button" data-bs-target="#exampleModal{{$leave->id}}" class="btn btn-default btn-xs">inbox <span class="glyphicon glyphicon-inbox"></span></button> -->
                    </td>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{route('accept.reject', [$leave->id])}}" method="post">@csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Leave</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    
                                    <div class="from-group"> 
                                            <lavel>{{__('messages.changeStatus')}}  </lavel>

                                            <select class="from-control" name="status">
                                                <option value="0">{{__('messages.pending')}} </option>
                                                <option value="1">{{__('messages.accept')}} </option>
                                                
                                            </select>
                                        </div>
                                        <div class="from-group mt-3"> 
                                        <label>{{__('messages.message')}} </label>
                                        <textarea class="form-control" name="message" rows="2" required=""></textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('messages.close')}} </button>
                                    <form action="#" method="post">@csrf
                                            
                                                <button class="btn btn-outline-danger">
                                                    {{__('messages.submit')}}
                                                </button>
                                    </form>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    </tr>
                   
                    @endforeach
                   
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
