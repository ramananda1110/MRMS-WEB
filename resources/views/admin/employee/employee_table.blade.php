<table id="employeeTable" class="table table-striped table-bordered datatable">
    <thead>
        <tr>
            <th scope="col">Employee ID</th>
            <th scope="col">Name</th>
            <th scope="col">Division</th>
            <th scope="col">Mobile</th>
            <th scope="col">Email</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (count($employees) > 0)
            @foreach ($employees as $key => $employee)
                <tr>
                    <th scope="row">{{ $employee->employee_id }}</th>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->division }}</td>
                    <td>{{ $employee->mobile_number }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $employee->id }}"
                            title="View">
                            <button type="button" class="btn btn-primary"><i class="fa-solid fa-eye"></i></button></a>
                        <a href="{{ route('employee.edit', [$employee->id]) }}" title="Edit">
                            <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></a>

                        <a data-bs-toggle="modal" data-bs-target="#exampleModal{{ $employee->id }}" href="#" title="Delete">
                            <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2{{ $employee->id }}" title="Add">
                            <button type="button" class="btn btn-success"><i
                                    class="fa-solid fa-user-plus"></i></button></a>




                        <!-- Add Modals for delete and create user actions here as in the original template -->


                        <!-- Modal delete -->
                        <div class="modal fade" id="exampleModal{{ $employee->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete!</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        Are you sure? do you want to delete item?

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <form action="{{ route('employee.destroy', [$employee->id]) }}" method="post">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="viewModal{{ $employee->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form>@csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Meeting Details</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table">
                                                        <tbody>

                                                            <tr>
                                                                <th>Employee ID</th>
                                                                <td>{{ $employee->employee_id }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Employee Name</th>
                                                                <td>{{ $employee->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Grade</th>
                                                                <td>{{ $employee->grade }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status</th>
                                                                <td>{{ $employee->status }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Division</th>
                                                                <td>{{ $employee->division }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Project Name</th>
                                                                <td>{{ $employee->project_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Project Code</th>
                                                                <td>{{ $employee->project_code }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Email</th>
                                                                <td>{{ $employee->email }}</td>
                                                            </tr>


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <!-- Add your form elements if needed -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="modal fade" id="exampleModal2{{ $employee->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('create.user', [$employee->id]) }}" method="post">@csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Create a User</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="card">

                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Division</label>
                                                        <select class="form-control" name="department_id"
                                                            require="">
                                                            @foreach (App\Models\Department::all() as $department)
                                                                <option value="{{ $department->id }}"
                                                                    @if ($department->name == $employee->division) selected @endif>
                                                                    {{ $department->name }}

                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>

                                                    <div class="form-group  mt-2">
                                                        <label>Role</label>
                                                        <select class="form-control" name="role_id" require="">
                                                            @foreach (App\Models\Role::all() as $role)
                                                                <option value="{{ $role->id }}">
                                                                    {{ $role->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>


                                                    <div class="form-group  mt-2">
                                                        <label for="name">Password</label>
                                                        <input type="password" name="password" class="form-control"
                                                            required="">
                                                    </div>


                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <form action="#" method="post">@csrf
                                                    <button class="btn btn-outline-success">
                                                        Create
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>


                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center">Opps! No matching record found!</td>
            </tr>
        @endif
    </tbody>
</table>
{{ $employees->links('pagination::bootstrap-4') }}
