@extends('admin.layouts.master')

@section('content')
    <div class="container mt-5">

        @if (Session::has('message'))
            <div class='alert alert-success'>
                {{ Session::get('message') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div class='alert alert-warning'>
                {{ Session::get('error') }}
            </div>
        @endif

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">{{__('messages.rescheduleMeeting')}} </li>
            </ol>
        </nav>

        <form id="meetingForm" action="{{ route('meeting.update', [$meeting->id]) }}" method="post">
            @csrf
            {{ method_field('PATCH') }}

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">{{__('messages.meetingInfo')}} </div>
                        <div class="card-body mt-1">

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{__('messages.meetingTitle')}} </label>
                                <div class="col-sm-9">
                                    <input type="text" name="meeting_title" value="{{ $meeting->meeting_title }}"
                                        class="form-control @error('meeting_title') is-invalid @enderror" required>
                                    @error('meeting_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">{{__(messages.room)}} </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="room_id" required>
                                        @foreach (App\Models\Room::all() as $room)
                                            <option value="{{ $room->id }}"
                                                @if ($room->id == $meeting->room_id) selected @endif>
                                                {{ $room->name }} <p>({{ $room->location }})</p>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">{{__('messages.startDate')}} </label>
                                <div class="col-sm-9">
                                    <input name="start_date" class="form-control" required
                                        value="{{ $meeting->start_date }}" id="datepicker" autocomplete="off">
                                    @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">{{__('messages.startTime')}} </label>
                                <div class="col-sm-9">
                                    <input name="start_time" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($meeting->start_time)->format('H:i') }}"
                                        data-placeholder="hh:mm" id="appt" type="time" required>
                                    @error('start_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">{{__('messages.endTime')}} </label>
                                <div class="col-sm-9">
                                    <input class="form-control"
                                        value="{{ \Carbon\Carbon::parse($meeting->end_time)->format('H:i') }}"
                                        data-placeholder="hh:mm" id="appt" type="time" name="end_time" required>
                                    @error('end_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">{{__('messages.host')}} </label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="host_id" required>
                                        @foreach ($activeEmployees as $host)
                                            <option value="{{ $host->employee_id }}"
                                                @if ($host->employee_id == $meeting->host_id) selected @endif>
                                                {{ $host->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="form-group row mt-3">
              <label class="col-sm-3 col-form-label">Co-Host</label>
              <div class="col-sm-9">
                <select class="form-control" name="co_host_id" >
                @foreach ($activeEmployees as $coHost)
                      
                  <option value="{{ $coHost->employee_id }}" @if ($coHost->employee_id == $meeting->co_host_id) selected @endif>
                      {{ $coHost->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div> --}}

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">{{__('messages.coHost')}} </label>
                                <div class="col-sm-9">
                                    <select name="co_host_id" id="choices-multiple-co-host-button">
                                        @foreach ($activeEmployees as $coHost)
                                            <option value="{{ $coHost->employee_id }}"
                                                @if ($coHost->employee_id == $meeting->co_host_id) selected @endif>
                                                {{ $coHost->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">{{__('messages.participants')}} </label>
                                <div class="col-sm-9">

                                    <select name="participants[]" id="choices-multiple-remove-button"
                                        placeholder="{{__('messages.selectParticipants')}}" multiple required>
                                        @foreach ($activeEmployees as $employee)
                                            <option value="{{ $employee->employee_id }}"
                                                @if ($meeting->participants->contains('participant_id', $employee->employee_id)) selected @endif>
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>





                            </div>
                        </div>

                        <div class="form-group row ms-1 mt-4">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary mb-3">{{__('messages.submit')}} </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>

    </form>

    <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitModalLabel">{{__('messages.submitConfirmation')}} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{__('messages.rescheduleMeetingMsg')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('messages.close')}} </button>
                    <button type="button" class="btn btn-outline-primary" id="confirmSubmitBtn">{{__('messages.confirm')}} </button>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const meetingForm = document.getElementById('meetingForm');
        const submitModal = document.getElementById('submitModal');

        meetingForm.addEventListener('submit', function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();
            event.stopPropagation();

            if (!meetingForm.checkValidity()) {
                // If the form is not valid, add Bootstrap's validation class
                meetingForm.classList.add('was-validated');

            } else {
                // Show confirmation modal if form is valid
                $('#submitModal').modal('show');
            }
        });

        // Add a click event listener to the confirmation button in the modal
        document.getElementById('confirmSubmitBtn').addEventListener('click', function() {
            // Manually submit the form if the user confirms in the modal
            meetingForm.submit();
        });


        var selectElement = document.getElementById('choices-multiple-remove-button');
        var choices = new Choices(selectElement, {
            removeItemButton: true,
            maxItemCount: 25,
            renderChoiceLimit: 10
        });
        var selectElement = document.getElementById('choices-multiple-co-host-button');
        var choices = new Choices(selectElement, {
            removeItemButton: true,
            maxItemCount: 1,
            renderChoiceLimit: 10
        });
    });
</script>
