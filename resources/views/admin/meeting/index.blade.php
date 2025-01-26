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
            <div class="loader">
                <img src="{{ asset('images/meeting animation.gif') }}" alt="">
            </div>

            <div class="col-md-11">


                <div class="card-body">
                    <div class="card mt-3" style="border-bottom: 1px solid silver;">
                        <div class="panel-heading no-print mt-2 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                @if (isset(Auth()->user()->role->permission['name']['meeting']['can-add']))
                                    <div class="ms-3 col-sm-4 mt-1 d-flex justify-content-start">
                                        <a href="{{ Route('meeting.create') }}"><button type="button"
                                                class="btn btn-primary btn-loader"><i class="fa fa-plus"></i>
                                                {{ __('messages.addMeeting') }} </button></a>


                                    </div>
                                @endif

                                <div class="btn-group d-flex justify-content-center align-items-center ms-2">
                                    <div class="row gx-0">
                                        <div class="col-md">
                                            <form action="{{ route('meetings.exportCsv') }}" method="get" target="_blank">
                                                @csrf
                                                <input type="hidden" name="filter" id="exportFilterCsv" value="0">
                                                <button
                                                    class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block"
                                                    tabindex="0" aria-controls="employees">
                                                    {{ __('messages.csv') }}
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md">

                                            <form action="{{ route('meetings.download-excel') }}" method="post"
                                                target="_blank">@csrf
                                                <input type="hidden" name="filter" id="exportFilterExcel" value="0">

                                                <button
                                                    class="btn btn-default buttons-csv border buttons-html5 btn-sm">{{ __('messages.excel') }}
                                                </button>

                                            </form>
                                        </div>
                                        <div class="col-md">
                                            <form action="{{ route('meetings.exportPdf') }}" method="get" target="_blank">
                                                <input type="hidden" name="filter" id="exportFilterPdf" value="0">

                                                <button
                                                    class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block">{{ __('messages.pdf') }}
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md">
                                            <form action="{{ route('meetings.printView') }}" method="get"
                                                target="_blank">
                                                <input type="hidden" name="filter" id="exportFilterPrint" value="0">

                                                <button
                                                    class="btn btn-default buttons-csv border buttons-html5 btn-sm btn-block">{{ __('messages.print') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Search input -->
                                    <div class="me-2">
                                        <input id="searchInput" type="text" name="search" class="form-control"
                                            placeholder="{{ __('messages.search') }}" style="width: 200px;">
                                    </div>

                                    <!-- Filter dropdown -->
                                    <select class="form-select form-select-mm me-2" aria-label=".form-select-lg example">
                                        <option value="0" selected>{{ __('messages.all') }} </option>
                                        <option value="1">{{ __('messages.past15Days') }} </option>
                                        <option value="2">{{ __('messages.past30Days') }}</option>
                                        <option value="3">{{ __('messages.past90Days') }}</option>
                                        <option value="4">{{ __('messages.past180Days') }}</option>
                                    </select>

                                </div>

                            </div>


                        </div>


                    </div>


                    <ul class="nav nav-tabs mt-3">
                        <li class="nav-item" role="presentation">

                            <a class="nav-link active" aria-current="page" href="{{ route('meetings.all') }}"
                                id="all" onclick="setActiveTab(event, this)">{{ __('messages.all') }} </a>

                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('meetings.upcoming') }}" id="upcoming"
                                onclick="setActiveTab(event, this)">{{ __('messages.upcoming') }} </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('meetings.pending') }}" id="pending"
                                onclick="setActiveTab(event, this)">{{ __('messages.pending') }} </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('meetings.cenceled') }}" id="canceled"
                                onclick="setActiveTab(event, this)">{{ __('messages.cancelled') }} </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('meetings.rejected') }}" id="rejected"
                                onclick="setActiveTab(event, this)">{{ __('messages.rejected') }} </a>
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


        document.addEventListener('DOMContentLoaded', (event) => {
            const selectElement = document.querySelector('.form-select');
            const searchInput = document.getElementById('searchInput');

            const exportFilterCsv = document.getElementById('exportFilterCsv');
            const exportFilterExcel = document.getElementById('exportFilterExcel');
            const exportFilterPdf = document.getElementById('exportFilterPdf');
            const exportFilterPrint = document.getElementById('exportFilterPrint');

            function updateData() {
                const filterValue = selectElement.value;
                const searchValue = searchInput.value;
                $.ajax({
                    url: '{{ route('search.meeting') }}',
                    method: 'GET',
                    data: {
                        filter: filterValue,
                        search: searchValue
                    },
                    success: function(response) {
                        $('#meetingTableContainer').html(response);
                    },
                    error: function(error) {
                        console.error('Error fetching filtered data:', error);
                    }
                });
            }

            selectElement.addEventListener('change', updateData);
            searchInput.addEventListener('input', updateData);


            selectElement.addEventListener('change', (event) => {
                const filterValue = event.target.value;
                exportFilterCsv.value = filterValue;
                exportFilterExcel.value = filterValue;
                exportFilterPdf.value = filterValue;
                exportFilterPrint.value = filterValue;
            });

        });

        document.querySelector('.btn-loader').addEventListener('click', function() {
            document.querySelector('.loader').style.display = 'block';
        })
    </script>
@endsection
@endsection
