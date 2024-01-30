@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row">
   
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">All Departments</li>
                </ol>
            </nav>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Edit</th>
                        <th>Delete</th>  
                    </tr>
                </thead>
                
                <tbody>
                    @if(count($departments)>0)
                          @foreach($departments as
                          $key=>$department)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$department->name}}</td>
                            <td>{{$department->description}}</td>
                           
                            <td> <a href="{{route('departments.edit',
                                    [$department->id])}}">
                                 <i class="fas fa-edit"></i></a> </td>
                            <td><i class="fas fa-trash"></i></td>
                        </tr>
                    @endforeach
                     @else
                     
                        <td> No Department to display</td>
                       
                      @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
