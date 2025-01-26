@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
<div class="row justify-content-center rounded shadow p-3 mb-5 bg-white" style="background-color: white">
    <div class="col-md-11 mt-3 mb-3">
            <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Update Permission From</li>
                </ol>
            </nav> -->
            @if(Session::has('message'))
                     <div class='alert alert-success'>
                          {{Session::get('message')}}
                      </div>
                @endif
            <form action="{{route('permissions.update', [$permission->id])}}" method="post">@csrf
            {{method_field('PATCH')}}
                <div class="card">
                    <div class="card-header">{{__('messages.updatePermissions')}} </div>

                    <div class="card-body">
                        <div class="form-group mt-2">
                        
                            <h3>{{$permission->role->name}}</h3>

                            <table class="table table-gray mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('messages.permissionType')}} </th>
                                        <th scope="col">{{__('messages.canAdd')}} </th>
                                        <th scope="col">{{__('messages.canEdit')}} </th>
                                        <th scope="col">{{__('messages.canView')}} </th>
                                        <th scope="col">{{__('messages.canDelete')}} </th>
                                        <th scope="col">{{__('messages.canList')}} </th>
                                        <th scope="col">{{__('messages.canReSchedule')}} </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>{{__('messages.user')}} </td>
                                        <td><input type="checkbox" name="name[user][can-add]"
                                            @if(isset($permission['name']['user']['can-add'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[user][can-edit]"
                                            @if(isset($permission['name']['user']['can-edit'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[user][can-view]"
                                            @if(isset($permission['name']['user']['can-view'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[user][can-delete]"
                                            @if(isset($permission['name']['user']['can-delete'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[user][can-list]"
                                            @if(isset($permission['name']['user']['can-list'])) checked @endif value="1"></td>
                                        <td></td>    
                                    
                                    </tr>

                                    <tr>
                                        <td>{{__('messages.role')}} </td>
                                        <td><input type="checkbox" name="name[role][can-add]" 
                                            @if(isset($permission['name']['role']['can-add'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[role][can-edit]"
                                             @if(isset($permission['name']['role']['can-edit'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[role][can-view]"
                                            @if(isset($permission['name']['role']['can-view'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[role][can-delete]"
                                            @if(isset($permission['name']['role']['can-delete'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[role][can-list]"
                                            @if(isset($permission['name']['role']['can-list'])) checked @endif value="1"></td>
                                        <td></td>    
                                    </tr>

                                    <tr>
                                        <td>{{__('messages.meeting')}} </td>
                                        <td><input type="checkbox" name="name[meeting][can-add]" 
                                            @if(isset($permission['name']['meeting']['can-add'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[meeting][can-edit]"
                                            @if(isset($permission['name']['meeting']['can-edit'])) checked @endif  value="1">
                                        </td>
                                        <td><input type="checkbox" name="name[meeting][can-view]" 
                                            @if(isset($permission['name']['meeting']['can-view'])) checked @endif  value="1"></td>
                                        <td><input type="checkbox" name="name[meeting][can-delete]" 
                                            @if(isset($permission['name']['meeting']['can-delete'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[meeting][can-list]" 
                                            @if(isset($permission['name']['meeting']['can-list'])) checked @endif value="1"></td>
                                    
                                        <td><input type="checkbox" name="name[meeting][can-reschedule]" 
                                        @if(isset($permission['name']['meeting']['can-reschedule'])) checked @endif value="1"></td>
                                    
                                    </tr>

                                    <tr>
                                        <td>{{__('messages.employee')}} </td>
                                        <td><input type="checkbox" name="name[employee][can-add]" 
                                            @if(isset($permission['name']['employee']['can-add'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[employee][can-edit]"
                                            @if(isset($permission['name']['employee']['can-edit'])) checked @endif  value="1">
                                        </td>
                                        <td><input type="checkbox" name="name[employee][can-view]" 
                                            @if(isset($permission['name']['employee']['can-view'])) checked @endif  value="1"></td>
                                        <td><input type="checkbox" name="name[employee][can-delete]" 
                                            @if(isset($permission['name']['employee']['can-delete'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[employee][can-list]" 
                                            @if(isset($permission['name']['employee']['can-list'])) checked @endif value="1"></td>
                                        <td></td>    
                                    </tr>

                                    <tr>
                                        <td>{{__('messages.division')}} </td>
                                        <td><input type="checkbox" name="name[department][can-add]" 
                                            @if(isset($permission['name']['department']['can-add'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[department][can-edit]"
                                            @if(isset($permission['name']['department']['can-edit'])) checked @endif  value="1">
                                        </td>
                                        <td><input type="checkbox" name="name[department][can-view]" 
                                            @if(isset($permission['name']['department']['can-view'])) checked @endif  value="1"></td>
                                        <td><input type="checkbox" name="name[department][can-delete]" 
                                            @if(isset($permission['name']['department']['can-delete'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[department][can-list]" 
                                            @if(isset($permission['name']['department']['can-list'])) checked @endif value="1"></td>
                                         <td></td>    
                                    </tr>
                                   
                                    
                                    <tr>
                                        <td>{{__('messages.permission')}} </td>
                                        <td><input type="checkbox" name="name[permission][can-add]"
                                            @if(isset($permission['name']['permission']['can-add'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[permission][can-edit]"
                                            @if(isset($permission['name']['permission']['can-edit'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[permission][can-view]"
                                            @if(isset($permission['name']['permission']['can-view'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[permission][can-delete]"
                                            @if(isset($permission['name']['permission']['can-delete'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[permission][can-list]"
                                            @if(isset($permission['name']['permission']['can-list'])) checked @endif value="1"></td>
                                         <td></td>         
                                    </tr>
                                    
                                   
                                    <tr>
                                        <td>{{__('messages.room')}} </td>
                                        <td><input type="checkbox" name="name[room][can-add]"
                                            @if(isset($permission['name']['room']['can-add'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[room][can-edit]"
                                            @if(isset($permission['name']['room']['can-edit'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[room][can-view]"
                                            @if(isset($permission['name']['room']['can-view'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[room][can-delete]"
                                            @if(isset($permission['name']['room']['can-delete'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[room][can-list]"
                                            @if(isset($permission['name']['room']['can-list'])) checked @endif value="1"></td>
                                        <td></td>    
                                    </tr>
                                    
                                   
                                    <tr>
                                        <td>{{__('messages.notice')}} </td>
                                        <td><input type="checkbox" name="name[notice][can-add]"
                                            @if(isset($permission['name']['notice']['can-add'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[notice][can-edit]"
                                            @if(isset($permission['name']['notice']['can-edit'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[notice][can-view]"
                                            @if(isset($permission['name']['notice']['can-view'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[notice][can-delete]"
                                            @if(isset($permission['name']['notice']['can-delete'])) checked @endif value="1"></td>
                                        <td><input type="checkbox" name="name[notice][can-list]"
                                            @if(isset($permission['name']['notice']['can-list'])) checked @endif value="1"></td>
                                         <td></td>    
                                    </tr>

                                    <!-- <tr>
                                        <td>Leave</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><input type="checkbox" name="name[leave][can-list]"
                                            @if(isset($permission['name']['leave']['can-list'])) checked @endif value="1"></td>
                                    
                                    </tr> -->

                                </tbody>
                            </table>

                            <div class="form-group mt-3">
                            @if(isset(Auth()->user()->role->permission['name']['permission']['can-edit']))

                            <button class="btn btn-outline-primary">{{__('messages.update')}} </button>

                            @endif

                            <a href="{{route('permissions.index')}}" class="float-end">{{__('messages.back')}} </a> 
                        </div>

                        </div>
                        
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
