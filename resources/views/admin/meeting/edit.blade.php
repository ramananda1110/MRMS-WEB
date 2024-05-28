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
      <li class="breadcrumb-item active" aria-current="page">Rechedule Meeting</li>
    </ol>
  </nav>

  <form id="meetingForm" action="{{ route('meeting.update', [$meeting->id]) }}" method="post" >
  @csrf
    {{ method_field('PATCH') }}

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">Meeting Information</div>
          <div class="card-body mt-1">

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Meeting Title</label>
              <div class="col-sm-9">
                <input type="text" name="meeting_title" value="{{ $meeting->meeting_title }}" class="form-control @error('meeting_title') is-invalid @enderror" required>
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
                <select class="form-control" name="room_id" required>
                  @foreach(App\Models\Room::all() as $room)
                    <option value="{{ $room->id }}" @if($room->id == $meeting->room_id) selected @endif>
                      {{ $room->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row mt-3">
              <label class="col-sm-3 col-form-label">Start Date</label>
              <div class="col-sm-9">
                <input name="start_date" class="form-control" required value="{{ $meeting->start_date }}" id="datepicker">
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
                <input name="start_time" class="form-control" value="{{ \Carbon\Carbon::parse($meeting->start_time)->format('H:i') }}" data-placeholder="hh:mm" id="appt" type="time" required>
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
                <input class="form-control" value="{{ \Carbon\Carbon::parse($meeting->end_time)->format('H:i') }}" data-placeholder="hh:mm" id="appt" type="time" name="end_time" required>
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
                <select class="form-control" name="host_id" required>
                @foreach($activeEmployees as $host)
               
                   <option value="{{ $host->employee_id }}" @if($host->employee_id == $meeting->host_id) selected @endif>
                      {{ $host->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row mt-3">
              <label class="col-sm-3 col-form-label">Co-Host</label>
              <div class="col-sm-9">
                <select class="form-control" name="co_host_id" required>
                @foreach($activeEmployees as $coHost)
                      
                  <option value="{{ $coHost->employee_id }}" @if($coHost->employee_id == $meeting->co_host_id) selected @endif>
                      {{ $coHost->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row mt-3">
              <label class="col-sm-3 col-form-label">Participant</label>
                <div class="col-sm-9">
                    <select name="participants[]" id="choices-multiple-remove-button" placeholder="Select up to 25 Participants" multiple required>
                        @foreach($activeEmployees as $employee)
                          <option value="{{ $employee->employee_id }}" 
                                @if(in_array($employee->employee_id, $meeting->updateParticipants()->pluck('employee_id')->toArray())) 
                                    selected 
                                @endif>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
           </div>

            <div class="form-group row ms-1 mt-4">
              <label class="col-sm-3 col-form-label"></label>
              <div class="col-sm-9">
                <button type="submit" class="btn btn-primary">Submit</button>
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
          Are you sure you want to Reschedule this meeting?
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
  document.addEventListener('DOMContentLoaded', function () {
    const meetingForm = document.getElementById('meetingForm');
    const submitModal = document.getElementById('submitModal');

    meetingForm.addEventListener('submit', function(event) {
    // Prevent the default form submission behavior
    event.preventDefault();
    event.stopPropagation();

      if (!meetingForm.checkValidity()) {
        // If the form is not valid, add Bootstrap's validation class
        meetingForm.classList.add('was-validated');
        
      }
      
      else {
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
  });
</script>


