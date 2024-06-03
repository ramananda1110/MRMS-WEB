@extends('admin.layouts.master')

@section('content')
    <div class="container mt-5">
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

        <div class="row justify-content-center px-2 py-2 rounded shadow p-3 mb-5 bg-white">
            @if (isset(Auth()->user()->role->permission['name']['employee']['can-add']))
                <div class="card ms-4 mt-3 me-4" style="border-bottom: 1px solid silver;">
                    <div class="panel-heading no-print mt-2 mb-2">
                        <div class="btn-group">
                            <a href="{{ Route('employee.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add Employee
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row mb-3 mt-3">
                <div class="col-sm-4">
                    <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset(Auth()->user()->role->permission['name']['employee']['can-add']))
                            <div class="input-group mt-2">
                                <input type="file" name="file" id="fileInput" placeholder="attached xlsx"
                                    class="form-control">
                                <button id="importButton" class="btn btn-outline-primary" disabled>Import</button>
                            </div>
                        @endif
                    </form>

                    <!-- Preview Button -->
                    @if (isset(Auth()->user()->role->permission['name']['employee']['can-add']))

                    <div class="mt-1">
                        <div class="d-flex align-items-center">
                            <p class="fs-6 fw-lighter me-2 mb-0">Download sample template for file import</p>
                            <a href="../preview/employee_preview.xlsx" download class="text-primary text-decoration-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download me-1 align-middle" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    @endif

                </div>

                <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    <div class="dt-buttons btn-group border">
                        <form action="{{ route('employee.exportCsv') }}" method="get" target="_blank">
                            <button class="btn btn-default buttons-csv border buttons-html5 btn-sm">Csv</button>
                        </form>
                        <form action="{{ route('employee.download-excel') }}" method="post" target="_blank">@csrf
                            <button class="btn btn-default buttons-csv border buttons-html5 btn-sm">Excel</button>
                        </form>
                        <form action="{{ route('employee.exportPdf') }}" method="get" target="_blank">
                            <button class="btn btn-default buttons-csv border buttons-html5 btn-sm">Pdf</button>
                        </form>
                        <form action="{{ route('employee.printView') }}" method="get" target="_blank">
                            <button class="btn btn-default buttons-csv border buttons-html5 btn-sm">Print</button>
                        </form>
                    </div>
                </div>

                <div class="col-sm-4 d-flex align-items-center justify-content-end">
                    <input id="searchInput" type="text" name="search" class="form-control" placeholder="Search..."
                        style="max-width: 200px;">
                </div>
            </div>


            <div class="card-body" id="employeeTableContainer">
                @include('admin.employee.employee_table', ['employees' => $employees])
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        document.getElementById('fileInput').addEventListener('change', function() {
            var fileInput = document.getElementById('fileInput');
            var importButton = document.getElementById('importButton');

            if (fileInput.files.length > 0) {
                importButton.removeAttribute('disabled');
            } else {
                importButton.setAttribute('disabled', 'disabled');
            }
        });



        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value;
                fetchEmployees(query);
            });

            function fetchEmployees(query) {
                fetch(`{{ route('search.employee') }}?search=${query}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('employeeTableContainer').innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error fetching employee data'); // Add this line
                    });
            }
        });
    </script>
@endsection
@endsection
