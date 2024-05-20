@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
       
    @endif
    @if(Session::has('error'))
    <div class='alert alert-danger'>
        {{Session::get('error')}}
    </div>
   
    @endif
    
    <div class="row justify-content-center rounded shadow p-3 mb-5 bg-white" style="background-color: white">


        <div class="col-md-11">
            
        
        <div class="card-body">
            <div class="card  mt-3 " style="border-bottom: 1px solid silver;">
                <div class="panel-heading no-print mt-2 mb-2">
                    <div class="btn-group ms-1">
                        <a href="{{Route('meeting.create')}}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add Meeting
                        </a>                           
                    </div>  
                </div>
            </div>

            <ul class="nav nav-tabs mt-3">
                <li class="nav-item" role="presentation">
                
                <a class="nav-link active" aria-current="page" href="{{ route('meetings.all') }}" id="all"  onclick="setActiveTab(event, this)">All</a>

                </li>
                <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('meetings.upcoming')}}"  id="upcoming" onclick="setActiveTab(event, this)">Upcoming</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="{{ route('meetings.pending') }}" id="pending" onclick="setActiveTab(event, this)" >Pending</a>
                </li>
                    <!-- Add more tabs if needed -->
            </ul>
        
            

            <table id="employeeTable" class="table table-striped table-bordered mt-5">
            
                <thead>
                    <tr>
                    
                    <th scope="col">Room Name</th>
                    <th scope="col">Meeting Title</th>
                    <th scope="col">Date</th>
                    <th scope="col">Duration</th>
                    
                    <th scope="col">Action</th>
                   
                    </tr>
                </thead>
                <tbody>

                    @if(count($meetings)>0)
                          @foreach($meetings as
                          $key=>$meeting)
                   
                    <tr>
                   
                        <th scope="row">{{$meeting->room->name}}</th>
                        <td>{{$meeting->meeting_title}}</td>
                        <td>{{ \Carbon\Carbon::parse($meeting->start_date)->format('F j, Y') }}</td>
                        <td>{{ DateTime::createFromFormat('H:i:s', $meeting->start_time)->format('h:i A') }} - {{ DateTime::createFromFormat('H:i:s', $meeting->end_time)->format('h:i A') }}</td>


                       <td > 
                        
                                <a  href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{$meeting->id}}" title="View">
                                <button type="button" class="btn btn-primary"><i class="fa-solid fa-eye"></i></button></a> 

                                @if($meeting->booking_status == 'pending')
                              
                                <a data-bs-toggle="modal" data-bs-target="#acceptModal{{$meeting->id}}", href="#" title="Accept">
                                    <button type="button" class="btn btn-success"><i class="fa-regular fa-square-check"></i></button></a> 
                               


                                <div class="modal fade" id="acceptModal{{$meeting->id}}" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="acceptModalLabel">Confirm!</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                       
                                        Are you sure? do you want to accept meeting?


                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form id="acceptMeetingForm{{$meeting->id}}" action="{{route('meetings.updateMeeting', [$meeting->id])}}" method="post">@csrf
                                            <input type="hidden" name="booking_status" id="accept_booking_status">
                                            <button class="btn btn-outline-success" onclick="submitForm('accepted', 'acceptMeetingForm{{$meeting->id}}')">
                                                ACCEPT
                                            </button>
                                        </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                
{{-- -------------------------------------------------------------------------------------------------- --}}

                                <a href="#" title="Re-schedule">
                                    <button type="button" class="btn btn-warning"><i class="fa-solid fa-calendar-days"></i></button></a> 
                              
                                <a data-bs-toggle="modal" data-bs-target="#rejectModal{{$meeting->id}}", href="#" title="Reject">
                                    <button type="button" class="btn btn-danger"><i class="fa-solid fa-ban"></i></button> </a> 
                               


                                <div class="modal fade" id="rejectModal{{$meeting->id}}" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="rejectModalLabel">Confirm!</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                       
                                        Are you sure? do you want to reject meeting?


                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form id="rejectMeetingForm{{$meeting->id}}" action="{{route('meetings.updateMeeting', [$meeting->id])}}" method="post">@csrf
                                            <input type="hidden" name="booking_status" id="reject_booking_status">
                                            <button class="btn btn-outline-danger" onclick="submitForm('rejected', 'rejectMeetingForm{{$meeting->id}}')">
                                                REJECT
                                            </button>
                                        </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @endif
                                    
                                        <div class="modal fade" id="viewModal{{$meeting->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form>@csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Meeting Details</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <table class="table">
                                                                        <tbody>
                                                                           
                                                                            <tr>
                                                                                <th>Meeting Title</th>
                                                                                <td>{{$meeting->meeting_title}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Room Name</th>
                                                                                <td>{{$meeting->room->name}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Room Location</th>
                                                                                <td>{{$meeting->room->location}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Start Date</th>
                                                                                <td>{{ \Carbon\Carbon::parse($meeting->start_date)->format('F j, Y') }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Start Time</th>
                                                                                <td>{{ DateTime::createFromFormat('H:i:s', $meeting->start_time)->format('h:i A') }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>End Time</th>
                                                                                <td>{{ DateTime::createFromFormat('H:i:s', $meeting->end_time)->format('h:i A') }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Host Name</th>
                                                                                <td>{{$meeting->host->name}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Co-Host Name</th>
                                                                                <td>{{$meeting->coHost->name}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Status</th>
                                                                                <td>{{$meeting->booking_status}}</td>
                                                                            </tr>
                                                                            <!-- Add more rows for other meeting details -->
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <!-- Add your form elements if needed -->
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        
                        

                        </td>

                    </tr>
                   
                    @endforeach
                    @else
                    
                    <p> No meeting found!</p>
                    
                    @endif
                </tbody>
            </table>
            
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

