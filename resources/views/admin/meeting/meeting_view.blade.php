@extends('admin.layouts.master')

@section('content')
    <form id="changepasswordform" action="/meeting-view/{id}" method="get" enctype="multipart/form-data">
        @csrf
        <div class="container mt-3">

            <div class="container  ">
                <div class="container mt-3 py-5">


                    <div class="row mt-3 d-flex justify-content-center">

                        <div class="col-lg-8">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">

                                    <div class="col-sm-3">
                                        <p class="mb-0 h4">Meeting Details</p>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Meeting ID</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $meeting->id }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Room Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $meeting->room->name }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Meeting Title</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $meeting->meeting_title }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Start Date</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $meeting->start_date }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Start Time</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $meeting->start_time }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">End Time</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $meeting->end_time }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Host ID</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $meeting->host_id }}</p>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Host Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $meeting->host->name }}</p>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Co-Host ID</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $meeting->co_host_id }}</p>

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Co-Host Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $meeting->coHost->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Participants</p>
                                        </div>
                                        <div class="col-sm-9">
                                            @foreach ($meeting->participants as $index => $participant)
                                                {{ $participant->employee->name }}
                                                @if ($index < count($meeting->participants) - 1)
                                                    ,
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Booking Status</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ $meeting->booking_status }}</p>
                                        </div>
                                    </div>
                                    <hr>

                                    @if ($meeting->booking_status == 'pending' && strtotime($meeting->start_date) >= strtotime(date('Y-m-d')))
                                            <a data-bs-toggle="modal" data-bs-target="#acceptModal{{ $meeting->id }}",
                                                href="#" title="Accept">
                                                <button type="button" class="btn btn-success">Accept</button></a>
                                      



                                        <div class="modal fade" id="acceptModal{{ $meeting->id }}" tabindex="-1"
                                            aria-labelledby="acceptModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="acceptModalLabel">Confirm!</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        Are you sure? do you want to accept meeting?


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <form id="acceptMeetingForm{{ $meeting->id }}"
                                                            action="{{ route('meeting.update.web', [$meeting->id]) }}"
                                                            method="post">@csrf
                                                            <input type="hidden" name="booking_status"
                                                                id="accept_booking_status">
                                                            <button class="btn btn-outline-success"
                                                                onclick="submitForm('accepted', 'acceptMeetingForm{{ $meeting->id }}')">
                                                                Accept
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif




                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



@endsection
