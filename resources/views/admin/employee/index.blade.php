@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{ Session::get('message') }}
        </div>
    @endif
    @if(Session::has('error'))
        <div class='alert alert-danger'>
            {{ Session::get('error') }}
        </div>
    @endif
    
    <div class="row justify-content-center px-2 py-2 rounded shadow p-3 mb-5 bg-white">
        <div class="card ms-4 mt-3 me-4" style="border-bottom: 1px solid silver;">
            <div class="panel-heading no-print mt-2 mb-2">
                <div class="btn-group">
                    <a href="{{ Route('employee.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add Employee
                    </a>                           
                </div>  
            </div>
        </div>
        
        <div class="row mb-3 mt-3">
            <div class="col-sm-4">
                <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">@csrf        
                    <div class="input-group mt-2"> 
                        <input type="file" name="file" placeholder="attached xlsx" class="form-control">
                        <button class="btn btn-outline-primary">Import</button>
                    </div>
                </form>
            </div>

            <div class="col-sm-4 text-center mt-2">
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

            <div class="col-sm-4 mt-2">
                <input id="searchInput" type="text" name="search" class="form-control" placeholder="name,phone,emp id...">
            </div>
        </div>

        <div class="card-body" id="employeeTableContainer">
            @include('admin.employee.employee_table', ['employees' => $employees])
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('input', function () {
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
            .catch(error => console.error('Error:', error));
        }
    });
</script>
@endsection
@endsection
