@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">All Permissions</li>
                </ol>
            </nav>
            @if(Session::has('message'))
                     <div class='alert alert-success'>
                          {{Session::get('message')}}
                      </div>
            @endif
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if(count($permissions)>0)
                          @foreach($permissions as
                          $key=>$permission)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$permission->role->name}}</td>
                           
                            <td> <a href="{{route('permissions.edit',
                                    [$permission->id])}}">
                                 <i class="fas fa-edit"></i></a> </td>
                            
                        </tr>
                    @endforeach
                     @else
                     
                        <td> No Permissions to display</td>
                       
                      @endif
                </tbody>
            </table>
        </div>
     </div>
</div>
@endsection
