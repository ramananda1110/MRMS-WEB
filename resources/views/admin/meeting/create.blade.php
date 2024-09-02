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
                <li class="breadcrumb-item active" aria-current="page">Create Meeting</li>
            </ol>
        </nav>

        <form id="meetingForm" action="{{ route('meetings.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">Meeting Information</div>
                        <div class="card-body mt-1">

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Meeting Title</label>
                                <div class="col-sm-9">
                                    <input type="text" name="meeting_title"
                                        class="form-control @error('meeting_title') is-invalid @enderror" required>
                                    @error('meeting_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">Room</label>
                                <div class="col-sm-9">
                                    <select class="form-control mt-1" name="room_id" required>
                                        <option value="">Select Room</option>
                                        @foreach (App\Models\Room::all() as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }} <p>({{ $room->location }})</p></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">Start Date</label>
                                <div class="col-sm-9">
                                    <input name="start_date" class="form-control" required placeholder="yyyy-mm-dd"
                                        id="datepicker" autocomplete="off">
                                    @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">Start Time</label>
                                <div class="col-sm-9">
                                    <input name="start_time" class="form-control" data-placeholder="hh:mm" id="appt"
                                        type="time" required>
                                    @error('start_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">End Time</label>
                                <div class="col-sm-9">
                                    <input class="form-control" data-placeholder="hh:mm" id="appt" type="time"
                                        name="end_time" required>
                                    @error('end_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">Host</label>
                                <div class="col-sm-9">
                                    <input type="text" name="host_id" value="{{ Auth::user()->name }}"
                                        class="form-control @error('host_id') is-invalid @enderror" disabled>

                                    <input type="hidden" name="host_id" value="{{ Auth::user()->employee_id }}">


                                </div>
                            </div>

                            {{-- <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">Co-Host</label>
                                <div class="col-sm-9">
                                    <select name="co_host_id" class="form-select" >
                                        <option value="">Select Co-Host</option>
                                        @foreach (App\Models\Employee::where('status', 'active')->get() as $co_host)
                                            <option value="{{ $co_host->employee_id }}">{{ $co_host->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">Co-Host</label>
                                <div class="col-sm-9">
                                    <select name="co_host_id" id="choices-multiple-co-host-button"
                                        placeholder="Select Co-Host" multiple required>
                                        
                                      
                                        <option value="">Select Co-Host</option>
                                        @foreach (App\Models\Employee::where('status', 'active')->get() as $co_host)
                                            <option value="{{ $co_host->employee_id }}">{{ $co_host->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <label class="col-sm-3 col-form-label">Participant</label>
                                <div class="col-sm-9">
                                    <select name="participants[]" id="choices-multiple-remove-button"
                                        placeholder="Select up to 25 Participants" multiple required>
                                        
                                      
                                        <!-- <option>{{ Auth::user()->name . ' - ' . Auth::user()->division }}</option> -->
                                       
                                        @foreach (App\Models\Employee::where('status', 'active')->get() as $employee)
                                            @if ($employee->employee_id != Auth::user()->employee_id)
                                                <option value="{{ $employee->employee_id }}">
                                                    {{ $employee->name . ' - ' . $employee->division }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>

                                </div>
                            </div>


                            <div class="form-group row ms-1 mt-4">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">Submit</button>
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
                        <h5 class="modal-title" id="submitModalLabel">Submit Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to create this meeting?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-primary" id="confirmSubmitBtn">Confirm</button>
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
