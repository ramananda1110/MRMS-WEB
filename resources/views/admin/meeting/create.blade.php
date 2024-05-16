@extends('admin.layouts.master')


@section('content')
<div class="container mt-5"  >
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
        
     @endif
     @if(Session::has('error'))
     <div class='alert alert-warning'>
            {{Session::get('error')}}
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
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Meeting Title</label>
                            <div class="col-sm-9">
                                <input name="meeting_title" class="form-control @error('meeting_title') is-invalid @enderror">
                                @error('meeting_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-2">
                            <label class="col-sm-3 col-form-label">Room</label>
                            <div class="col-sm-9">
                                <select class="form-control mt-1" name="room_id" required="">
                                    @foreach(App\Models\Room::all() as $room)
                                        <option value="{{$room->id}}">{{$room->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row mt-2">
                            <label class="col-sm-3 col-form-label">Start Date</label>
                            <div class="col-sm-9">
                                <input  name="start_date"
                                class="form-control" required="" placeholder="yy-mm-dd" id="datepicker">

                                @error('start_from')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <!-- id="appt -->
                        <div class="form-group row mt-2">
                            <label  class="col-sm-3 col-form-label">Start Time</label>
                            <div class="col-sm-9">
                                <input class="form-control"  name="start_time" >  
                                @error('start_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mt-2">
                            <label  class="col-sm-3 col-form-label">End Time</label>
                            <div class="col-sm-9">

                                <input class="form-control"  name="end_time">  
                                @error('end_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-2">
                            <label class="col-sm-3 col-form-label">Host</label>
                            <div class="col-sm-9">

                                <select  name="host_id" class="form-select" id="select_box">
                                    @foreach(App\Models\Employee::all() as $employee)
                                    <option value="{{$employee->employee_id}}">{{$employee->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row mt-2">
                            <label  class="col-sm-3 col-form-label">Co-Host</label>
                            <div class="col-sm-9">

                                <select  name="co_host_id" class="form-select" id="select_box">
                                    @foreach(App\Models\Employee::all() as $employee)
                                    <option value="{{$employee->employee_id}}">{{$employee->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row  mt-2">
                            <label class="col-sm-3 col-form-label">Participant</label>
                            <div class="col-sm-9">

                                <select name="participants[]" id="choices-multiple-remove-button" placeholder="Select up to 25 Participants" multiple>
                                    @foreach(App\Models\Employee::all() as $employee)
                                    <option value="{{ $employee->employee_id }}">{{ $employee->name . ' - ' . $employee->division }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    
                        <div class="form-group row   ms-1 mt-4"  >
                            <label class="col-sm-3 col-form-label"></label>
                            <button type="button" class="btn btn-outline-primary col-sm-3" data-bs-toggle="modal" data-bs-target="#submitModal">Submit</button>

                        </div>

                   
                      <!-- Modal for Confirmation -->
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
                                        <button type="submit" class="btn btn-outline-primary" form="meetingForm">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

            </div>

        </div>

      </div>
    </form>
</div>
@endsection



<script>

    var select_box_element = document.querySelector('#select_box');

    dselect(select_box_element, {
        search: true
    });

</script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var selectElement = document.getElementById('choices-multiple-remove-button');
         

            var choices = new Choices(selectElement, {
                removeItemButton: true,
                maxItemCount: 25,
                renderChoiceLimit: 10
            });
        });
    </script>

   

