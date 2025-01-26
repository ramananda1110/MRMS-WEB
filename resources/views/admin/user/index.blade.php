@extends('admin.layouts.master')

@section('content')
    <div class="container mt-5 rounded shadow p-3 mb-5 bg-white" style="background-color: white">

        <nav aria-label="breadcrumb" class="mt-3 ms-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">{{__('messages.allUser')}} </li>
            </ol>
        </nav>
        @if (Session::has('message'))
            <div class='alert alert-success'>
                {{ Session::get('message') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class='alert alert-danger'>
                {{ Session::get('error') }}
            </div>
        @endif
        
     <div class="row justify-content-center">


        <div class="col-md-11">
            <div class="card mt-3" style="border-bottom: 1px solid silver;">
                <div class="panel-heading no-print mt-2 mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        @if (isset(Auth()->user()->role->permission['name']['user']['can-add']))

                        <div class="ms-3">
                            <a href="{{ Route('users.create') }}"><button type="button" class="btn btn-primary"><i
                                        class="fa fa-plus"></i>{{__('messages.addUser')}} </button></a>
                        </div>
                        @endif
                        <div class="btn-group d-flex justify-content-center align-items-center me-3">
                            <div class="row gx-0">
                                <div class="dt-buttons btn-group border">
                                    <form action="{{ route('users.export-csv') }}" method="GET" target="_blank">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block"
                                            tabindex="0" aria-controls="employees">
                                            <span>{{__('messages.csv')}}</span>
                                        </button>
                                    </form>
                               
                                
                                    <form action="#" method="post" target="_blank">
                                        @csrf
                                        <button
                                            class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block">{{__('messages.excel')}}</button>
                                    </form>
                                
                
                                    <form action="{{ route('users.exportPdf') }}" method="GET" target="_blank">
                                        @csrf
                                        <button
                                            class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block">{{__('messages.pdf')}}</button>
                                    </form>
                                
                                    <form action="{{ route('users.printView') }}" method="get" target="_blank">
                                        <button class="btn btn-default buttons-csv border buttons-html5 btn-sm">{{__('messages.print')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body" id="employeeTableContainer">
                @include('admin.user.user_table', ['user' => $users])
            </div>

        </div>
     </div>
    </div>
@endsection
