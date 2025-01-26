@extends('admin.layouts.master')

@section('content')

    <div class="container mt-3">

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

        <div class="container  ">
            <div class="container mt-3 py-5">


                <div class="row mt-3 d-flex justify-content-center">

                    <div class="col-lg-8">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">

                                <div class="col-sm-3">
                                    <p class="mb-0 h4">{{__('messages.meetingDetails')}}</p>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('messages.meetingId')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $meeting->id }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('messages.roomName')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $meeting->room->name }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('messages.meetingTitle')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $meeting->meeting_title }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('messages.startDate')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $meeting->start_date }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('messages.startTime')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $meeting->start_time }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('messages.endTime')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $meeting->end_time }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('messages.hostId')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $meeting->host_id }}</p>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('messages.hostName')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $meeting->host->name }}</p>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('messages.coHostId')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $meeting->co_host_id }}</p>

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('messages.coHostName')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $meeting->coHost->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{__('messages.participants')}}</p>
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
                                        <p class="mb-0">{{__('messages.bookingStatus')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ $meeting->booking_status }}</p>
                                    </div>
                                </div>
                                <hr>

                                @if (isset(Auth()->user()->role->permission['name']['meeting']['can-edit']))
                                    @if ($meeting->booking_status == 'pending' && strtotime($meeting->start_date) >= strtotime(date('Y-m-d')))
                                        <a data-bs-toggle="modal" data-bs-target="#acceptModal{{ $meeting->id }}",
                                            href="#" title="Accept">
                                            <button type="button" class="btn btn-success">{{__('messages.accept')}}</button></a>

                                        <div class="modal fade" id="acceptModal{{ $meeting->id }}" tabindex="-1"
                                            aria-labelledby="acceptModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="acceptModalLabel">{{__('messages.confirm')}}
                                                            !</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        {{__('messages.meetingAcceptMsg')}}

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{__('messages.close')}} </button>
                                                        <form id="acceptMeetingForm{{ $meeting->id }}"
                                                            action="{{ route('meeting.update.web', [$meeting->id]) }}"
                                                            method="post">@csrf
                                                            <input type="hidden" name="booking_status"
                                                                id="accept_booking_status">
                                                            <button class="btn btn-outline-success"
                                                                onclick="submitForm('accepted', 'acceptMeetingForm{{ $meeting->id }}')">
                                                                {{ __('messages.accept') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif


                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection



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
</script>
