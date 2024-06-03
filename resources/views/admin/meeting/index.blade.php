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

        <div class="row justify-content-center rounded shadow p-3 mb-5 bg-white" style="background-color: white">


            <div class="col-md-11">


                <div class="card-body">
                    <div class="card mt-3" style="border-bottom: 1px solid silver;">
                        <div class="panel-heading no-print mt-2 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                @if (isset(Auth()->user()->role->permission['name']['meeting']['can-add']))
                                    <div class="ms-3 col-sm-4 mt-1 d-flex justify-content-start">
                                        <a href="{{ Route('meeting.create') }}"><button type="button"
                                                class="btn btn-primary"><i class="fa fa-plus"></i> Add Meeting</button></a>


                                    </div>
                                @endif

                                <div class="btn-group d-flex justify-content-center align-items-center ms-2">
                                    <div class="row gx-0">
                                        <div class="col-md">
                                            <form action="{{ route('meetings.exportCsv') }}" method="get" target="_blank">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block"
                                                    tabindex="0" aria-controls="employees">
                                                    <span>Csv</span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md">

                                            <form action="{{ route('meetings.download-excel') }}" method="post"
                                                target="_blank">@csrf

                                                <button
                                                    class="btn btn-default buttons-csv border buttons-html5 btn-sm">Excel</button>

                                            </form>
                                        </div>
                                        <div class="col-md">
                                            <form action="{{ route('meetings.exportPdf') }}" method="get" target="_blank">
                                                <button
                                                    class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block">Pdf</button>
                                            </form>
                                        </div>
                                        <div class="col-md">
                                            <form action="{{ route('meetings.printView') }}" method="get" target="_blank">
                                                <button
                                                    class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block">Print</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">


                                    <!-- Filter dropdown -->
                                    <div class="dropdown me-2">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-filter"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                            <!-- Dummy data in radio button format -->
                                            <li>
                                                <label class="dropdown-item">
                                                    <input type="radio" class="filter-radio" name="filterOption" value="5"> Previous 5 days
                                                </label>
                                            </li>
                                            <li>
                                                <label class="dropdown-item">
                                                    <input type="radio" class="filter-radio" name="filterOption" value="10"> Previous 10 days
                                                </label>
                                            </li>
                                            <li>
                                                <label class="dropdown-item">
                                                    <input type="radio" class="filter-radio" name="filterOption" value="15"> Previous 15 days
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <!-- Search input -->
                                    <div class="me-3">
                                        <input id="searchInput" type="text" name="search" class="form-control"
                                            placeholder="Search..." style="width: 200px;">
                                    </div>
                                </div>




                            </div>


                        </div>


                    </div>


                    <ul class="nav nav-tabs mt-3">
                        <li class="nav-item" role="presentation">

                            <a class="nav-link active" aria-current="page" href="{{ route('meetings.all') }}" id="all"
                                onclick="setActiveTab(event, this)">All</a>

                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('meetings.upcoming') }}" id="upcoming"
                                onclick="setActiveTab(event, this)">Upcoming</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('meetings.pending') }}" id="pending"
                                onclick="setActiveTab(event, this)">Pending</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('meetings.cenceled') }}" id="canceled"
                                onclick="setActiveTab(event, this)">Canceled</a>
                        </li>
                        <!-- Add more tabs if needed -->
                    </ul>

                    <div class="card-body" id="meetingTableContainer">
                        @include('admin.meeting.meeting_table', ['meeting' => $meetings])
                    </div>


                </div>

            </div>

        </div>


    </div>


@section('scripts')
    <script>
        function setActiveTab(event, element) {
            // Prevent the default link behavior
            event.preventDefault();

            // Remove the 'active' class from all nav links
            var navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(function(link) {
                link.classList.remove('active');
            });

            // Add the 'active' class to the clicked nav link
            element.classList.add('active');

            // Redirect to the link's href
            window.location.href = element.getAttribute('href');
        }

        function submitForm(status, formId) {
            document.getElementById(formId).querySelector('[name="booking_status"]').value = status;
            document.getElementById(formId).submit();
        }



        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value;
                fetchEmployees(query);
            });

            function fetchEmployees(query) {
                fetch(`{{ route('search.meeting') }}?search=${query}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('meetingTableContainer').innerHTML = data;
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
