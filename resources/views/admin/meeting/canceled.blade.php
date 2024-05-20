@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
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
                
                <a class="nav-link" aria-current="page" href="{{ route('meetings.all') }}" id="all"  onclick="setActiveTab(event, this)">All</a>

                </li>
                <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('meetings.upcoming')}}"  id="upcoming" onclick="setActiveTab(event, this)">Upcoming</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="{{ route('meetings.pending') }}" id="pending" onclick="setActiveTab(event, this)" >Pending</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" href="{{ route('meetings.cenceled') }}" id="canceled" onclick="setActiveTab(event, this)" >Canceled</a>
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
                    <th scope="col">Status</th>

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
                        @if($meeting->booking_status == 'accepted')
                        <td class="text-center"><span class="badge rounded-pill badge-primary bg-success">{{$meeting->booking_status}}</span></td>
                        @elseif($meeting->booking_status == 'rejected')
                            <td class="text-center"><span class="badge rounded-pill badge-primary bg-danger">{{$meeting->booking_status}}</span></td>
                        @else
                            <td class="text-center"><span class="badge rounded-pill badge-primary bg-primary">{{$meeting->booking_status}}</span></td>
                        @endif
                        <!-- <td> 
                        
                                <a  href="#">
                                <button type="button" class="btn btn-secondary">Re-schedule</button></a> 
                               
                        

                        </td> -->

                        
                       <td class="text-center"> 
                        
                        <a href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{$meeting->id}}" title="View">
                        <button type="button" class="btn btn-primary"><i class="fa-solid fa-eye"></i></button></a> 

                        
                      
                      
                            
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
</script>