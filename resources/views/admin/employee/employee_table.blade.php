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
        @if(count($employees) > 0)
            @foreach($employees as $key => $employee)
                <tr>
                    <th scope="row">{{$employee->employee_id}}</th>
                    <td>{{$employee->name}}</td>
                    <td>{{$employee->division}}</td>
                    <td>{{$employee->mobile_number}}</td>
                    <td>{{$employee->email}}</td>
                    <td>
                        <a href="{{route('employee.edit', [$employee->id])}}">
                            <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></a>
                        <a data-bs-toggle="modal" data-bs-target="#exampleModal{{$employee->id}}" href="#">
                            <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2{{$employee->id}}">
                            <button type="button" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i></button></a>
                        <!-- Add Modals for delete and create user actions here as in the original template -->
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6">No user found!</td>
            </tr>
        @endif
    </tbody>
</table>
{{$employees->links('pagination::bootstrap-4')}}
