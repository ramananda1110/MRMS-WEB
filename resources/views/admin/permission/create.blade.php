@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center rounded shadow p-3 mb-5 bg-white" style="background-color: white">

        <div class="col-md-11 mt-3 mb-3">
            <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Permision From</li>
                </ol>
            </nav> -->
            @if(Session::has('message'))
                     <div class='alert alert-success'>
                          {{Session::get('message')}}
                      </div>
            @endif

            @if (Session::has('error'))
                <div class='alert alert-warning'>
                {{Session::get('error') }}
                </div>
            @endif

            <form action="{{route('permissions.store')}}" method="post">@csrf
                <div class="card">
                    <div class="card-header">Create Permission</div>

                    <div class="card-body">
                        <div class="form-group mt-2">
                        
                            <select class="form-control  mt-2 @error('role_id') is-invalid @enderror" name="role_id">
                                <option value="">Select Role</option>
                        
                                @foreach(App\Models\Role::all() as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                               
                                @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </select>

                            <table class="table table-gray mt-3">
                                <thead>
                                    <tr>
                                    <th scope="col">Permission Type</th>
                                    <th scope="col">can-add</th>
                                    <th scope="col">can-edit</th>
                                    <th scope="col">can-view</th>
                                    <th scope="col">can-delete</th>
                                    <th scope="col">can-list</th>
                                    <th scope="col">can-rechedule</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>User</td>
                                        <td><input type="checkbox" name="name[user][can-add]" value="1"></td>
                                        <td><input type="checkbox" name="name[user][can-edit]" value="1"></td>
                                        <td><input type="checkbox" name="name[user][can-view]" value="1"></td>
                                        <td><input type="checkbox" name="name[user][can-delete]" value="1"></td>
                                        <td><input type="checkbox" name="name[user][can-list]" value="1"></td>
                                        <td></td>    
                                    </tr>

                                    <tr>
                                        <td>Role</td>
                                        <td><input type="checkbox" name="name[role][can-add]" value="1"></td>
                                        <td><input type="checkbox" name="name[role][can-edit]" value="1"></td>
                                        <td><input type="checkbox" name="name[role][can-view]" value="1"></td>
                                        <td><input type="checkbox" name="name[role][can-delete]" value="1"></td>
                                        <td><input type="checkbox" name="name[role][can-list]" value="1"></td>
                                        <td></td>    
                                    </tr>
                                    
                                    <tr>
                                        <td>Meeting</td>
                                        <td><input type="checkbox" name="name[meeting][can-add]" value="1"></td>
                                        <td><input type="checkbox" name="name[meeting][can-edit]" value="1"></td>
                                        <td><input type="checkbox" name="name[meeting][can-view]" value="1"></td>
                                        <td><input type="checkbox" name="name[meeting][can-delete]" value="1"></td>
                                        <td><input type="checkbox" name="name[meeting][can-list]" value="1"></td>
                                        <td><input type="checkbox" name="name[meeting][can-reschedule]" value="1"></td>

                                    
                                    </tr>

                                    <tr>
                                        <td>Employee</td>
                                        <td><input type="checkbox" name="name[employee][can-add]" value="1"></td>
                                        <td><input type="checkbox" name="name[employee][can-edit]" value="1"></td>
                                        <td><input type="checkbox" name="name[employee][can-view]" value="1"></td>
                                        <td><input type="checkbox" name="name[employee][can-delete]" value="1"></td>
                                        <td><input type="checkbox" name="name[employee][can-list]" value="1"></td>
                                        <td></td>    
                                    </tr>

                                    <tr>
                                        <td>Department</td>
                                        <td><input type="checkbox" name="name[department][can-add]" value="1"></td>
                                        <td><input type="checkbox" name="name[department][can-edit]" value="1"></td>
                                        <td><input type="checkbox" name="name[department][can-view]" value="1"></td>
                                        <td><input type="checkbox" name="name[department][can-delete]" value="1"></td>
                                        <td><input type="checkbox" name="name[department][can-list]" value="1"></td>
                                        <td></td>    
                                    </tr>
                                   
                                    
                                    <tr>
                                        <td>Permissions</td>
                                        <td><input type="checkbox" name="name[permission][can-add]" value="1"></td>
                                        <td><input type="checkbox" name="name[permission][can-edit]" value="1"></td>
                                        <td><input type="checkbox" name="name[permission][can-view]" value="1"></td>
                                        <td><input type="checkbox" name="name[permission][can-delete]" value="1"></td>
                                        <td><input type="checkbox" name="name[permission][can-list]" value="1"></td>
                                        <td></td>    
                                    </tr>
                                    
                                    
                                    
                                    <tr>
                                        <td>Room</td>
                                        <td><input type="checkbox" name="name[room][can-add]" value="1"></td>
                                        <td><input type="checkbox" name="name[room][can-edit]" value="1"></td>
                                        <td><input type="checkbox" name="name[room][can-view]" value="1"></td>
                                        <td><input type="checkbox" name="name[room][can-delete]" value="1"></td>
                                        <td><input type="checkbox" name="name[room][can-list]" value="1"></td>
                                        <td></td>    
                                    </tr>
                                    

                                    <tr>
                                        <td>Notice</td>
                                        <td><input type="checkbox" name="name[notice][can-add]" value="1"></td>
                                        <td><input type="checkbox" name="name[notice][can-edit]" value="1"></td>
                                        <td><input type="checkbox" name="name[notice][can-view]" value="1"></td>
                                        <td><input type="checkbox" name="name[notice][can-delete]" value="1"></td>
                                        <td><input type="checkbox" name="name[notice][can-list]" value="1"></td>
                                        <td></td>    
                                    </tr>

                                    <!-- <tr>
                                        <td>Leave</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><input type="checkbox" name="name[leave][can-list]" value="1"></td>
                                    
                                    </tr> -->


                                    
                                </tbody>
                            </table>

                            <div class="form-group mt-3">
                            <button class="btn btn-outline-primary">Submit</button>
                        </div>

                        </div>
                        
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
