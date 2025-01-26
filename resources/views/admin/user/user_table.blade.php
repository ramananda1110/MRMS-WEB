<table id="userTable" class="table table-striped table-bordered mt-5">
    <thead>
        <tr>
            <th>{{__('messages.sn')}} </th>
            <!-- <th>Photo</th> -->
            <th>{{__('messages.name')}} </th>
            <th>{{__('messages.empId')}} </th>
            <th>{{__('messages.role')}} </th>

            <th>{{__('messages.designation')}} </th>
            <!-- <th>Start Date</th> -->
            <!-- <th>Address</th> -->
            <!-- <th>Mobile</th> -->
            <th>{{__('messages.email')}} </th>
            <th>{{__('messages.division')}} </th>
            @if (Auth::check() &&
                    Auth::user()->role &&
                    Auth::user()->role->permission &&
                    Auth::user()->role->permission->role_id == 1)
                <th>Action</th>
            @endif

        </tr>
    </thead>

    <tbody>
        @if (count($users) > 0)
            @foreach ($users as $key => $user)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <!-- <td><image src="{{ asset('profile') }}//{{ $user->image }}" width="50"></td> -->
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->employee_id }}</td>
                    <td><span class="badge bg-success">{{ $user->role->name }}</span></td>
                    <td>{{ $user->department->name }}</td>

                    <!-- <td>{{ $user->start_from }}</td> -->
                    <!-- <td>{{ $user->address }}</td> -->
                    <!-- <td>{{ $user->mobile_number }}</td> -->
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->designation }}</td>

                    @if (isset(Auth()->user()->role->permission['name']['user']['can-edit']))
                        <td>
                            

                            @if (isset(Auth()->user()->role->permission['name']['user']['can-view']))
                                <div class="d-flex align-items-center">

                                    <a href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $user->id }}"
                                        title="View">
                                        <button type="button" class="btn btn-primary me-2"><i
                                                class="fa-solid fa-eye"></i></button></a>
                                    <!-- </td> -->
                            @endif

                            <div class="modal fade" id="viewModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form>@csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('messages.userDetails')}} </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <table class="table">
                                                            <tbody>
    
                                                                <tr>
                                                                    <th>{{__('messages.empId')}} </th>
                                                                    <td>{{ $user->employee_id }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>{{__('messages.empName')}} </th>
                                                                    <td>{{ $user->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>{{__('messages.designation')}} </th>
                                                                    <td>{{ $user->designation }}</td>
                                                                </tr>
                                                               
                                                                <tr>
                                                                    <th>{{__('messages.division')}} </th>
                                                                    <td>{{ $user->department->name }}</td>
                                                                </tr>
                                                                {{-- 
                                                                    <tr>
                                                                        <th>Project Name</th>
                                                                        <td>{{ $user->employee->project_name }}</td>
                                                                    </tr> 
                                                                 --}}
                                                                <tr>
                                                                    <th>{{__('messages.role')}} </th>
                                                                    <td>{{ $user->role->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>{{__('messages.projectCode')}} </th>
                                                                    <td>{{ $user->project_code }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>{{__('messages.email')}} </th>
                                                                    <td>{{ $user->email }}</td>
                                                                </tr>
    
    
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">{{__('messages.close')}} </button>
                                                <!-- Add your form elements if needed -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            @if (isset(Auth()->user()->role->permission['name']['user']['can-edit']))
                                <div class="d-flex align-items-center">

                                    <a href="{{ route('users.edit', [$user->id]) }}">
                                        <button type="button" class="btn btn-primary"> <i
                                                class="fas fa-edit"></i></button></a>
                                    <!-- </td> -->
                            @endif
                            <!-- <td> -->

                            <!-- Button trigger modal -->
                            @if (isset(Auth()->user()->role->permission['name']['user']['can-delete']))
                                <a data-bs-toggle="modal" data-bs-target="#exampleModal{{ $user->id }}",
                                    href="#">
                                    <button type="button" class="btn btn-danger ms-2"><i
                                            class="fas fa-trash"></i></button>
                                </a>
                            @endif

                            <a data-bs-toggle="modal" data-bs-target="#acceptModal{{ $user->id }}", href="#"
                                title="Accept" class="form-check form-switch ms-2">
                                <input class="form-check form-switch form-check-input" type="checkbox"
                                    id="flexSwitchCheckChecked" role="switch" {{ $user->is_active ? 'checked' : '' }}
                                    onclick="toggleUserActivation(this)">
                            </a>

                            <div class="modal fade" id="acceptModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="acceptModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="acceptModalLabel">{{__('messages.confirm')}} !</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            {{__('messages.userStatusChangeMsg')}}


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">{{__('messages.close')}} </button>
                                            <form id="updateUser{{ $user->id }}"
                                                action="{{ route('user.updateStatus', [$user->id]) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="is_active"
                                                    value="{{ $user->is_active ? '0' : '1' }}"
                                                    id="isActiveInput{{ $user->id }}">
                                                <button class="btn btn-outline-success">
                                                    {{__('messages.accept')}}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endif


                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{ $user->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('messages.delete')}} !</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- {{ $user->id }} -->
                                   {{__('messages.deleteMsg')}}


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">{{__('messages.close')}} </button>
                                    <form action="{{ route('users.destroy', [$user->id]) }}" method="post">@csrf
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
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="9" class="text-center">{{__('messages.noUserFoundMsg')}} </td>
            </tr>

        @endif
    </tbody>
</table>
