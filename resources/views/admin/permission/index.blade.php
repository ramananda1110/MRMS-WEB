@extends('admin.layouts.master')

@section('content')
    <div class="container mt-5 rounded shadow p-3 mb-5 bg-white" style="background-color: white">

        @if (Session::has('message'))
            <div class='alert alert-success'>
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-11">
                @if (isset(Auth()->user()->role->permission['name']['permission']['can-add']))
                    <div class="card mt-3" style="border-bottom: 1px solid silver;">
                        <div class="panel-heading no-print mt-2 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="ms-3">
                                    <a href="{{ Route('permissions.create') }}"><button type="button"
                                            class="btn btn-primary"><i class="fa fa-plus"></i>{{__('messages.addPermissions')}} </button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-3">
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.allPermissions')}} </li>
                    </ol>
                </nav>


                <table id="permissionTable" class="table table-striped table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>{{__('messages.sn')}} </th>
                            <th>{{__('messages.name')}} </th>
                            @if (isset(Auth()->user()->role->permission['name']['permission']['can-edit']))

                            <th>{{__('messages.edit')}} </th>
                            @endif
                            @if (isset(Auth()->user()->role->permission['name']['permission']['can-delete']))

                            <th>{{__('messages.delete')}} </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($permissions) > 0)
                            @foreach ($permissions as $key => $permission)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $permission->role->name }}</td>
                                    @if (isset(Auth()->user()->role->permission['name']['permission']['can-edit']))

                                    <td>
                                            <a
                                                href="{{ route('permissions.edit', [$permission->id]) }}"><button
                                                    type="button" class="btn btn-primary"><i
                                                        class="fas fa-edit"></i></button></a>
                                    </td>
                                    @endif
                                    @if (isset(Auth()->user()->role->permission['name']['permission']['can-delete']))

                                    <td>

                                        <!-- Button trigger modal -->
                                            <a data-bs-toggle="modal" data-bs-target="#exampleModal{{ $permission->id }}",
                                                href="#">
                                                <button type="button" class="btn btn-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $permission->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('messages.delete')}} !</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- {{ $permission->id }} -->

                                                        {{__('messages.deleteMsg')}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{__('messages.close')}} </button>
                                                        <form
                                                            action="{{ route('permissions.destroy', [$permission->id]) }}"
                                                            method="post">@csrf
                                                            {{ method_field('DELETE') }}
                                                            <button class="btn btn-outline-danger">
                                                                {{__('messages.delete')}}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    @endif


                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">{{__('messages.noPermissionDisplayMsg')}} </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
