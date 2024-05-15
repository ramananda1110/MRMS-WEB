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

            <ul class="nav nav-tabs">
                <li class="nav-item" role="presentation">
                
                <a class="nav-link" aria-current="page" href="{{ route('meetings.all') }}" id="all"  onclick="setActiveTab(event, this)">All</a>

                </li>
                <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('meetings.upcoming')}}"  id="upcoming" onclick="setActiveTab(event, this)">Upcoming</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" href="{{ route('meetings.pending') }}" id="pending" onclick="setActiveTab(event, this)" >Pending</a>
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
                     
                        <!-- <td> 
                        
                                <a  href="#">
                                <button type="button" class="btn btn-secondary">Re-schedule</button></a> 
                               
                        

                        </td> -->

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