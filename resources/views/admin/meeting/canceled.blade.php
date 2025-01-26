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
            <div class="card mt-3" style="border-bottom: 1px solid silver;">
                @if (isset(Auth()->user()->role->permission['name']['meeting']['can-add']))

                <div class="panel-heading no-print mt-2 mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="ms-3">
                            <a href="{{ Route('meeting.create') }}"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('messages.addMeeting')}} </button></a>
                        </div>
                          
                    </div>
                </div>
                @endif
            </div>

            <ul class="nav nav-tabs mt-3">
                <li class="nav-item" role="presentation">
                
                <a class="nav-link" aria-current="page" href="{{ route('meetings.all') }}" id="all"  onclick="setActiveTab(event, this)">{{__('messages.all')}} </a>

                </li>
                <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('meetings.upcoming')}}"  id="upcoming" onclick="setActiveTab(event, this)">{{__('messages.upcoming')}} </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="{{ route('meetings.pending') }}" id="pending" onclick="setActiveTab(event, this)" >{{__('messages.pending')}} </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" href="{{ route('meetings.cenceled') }}" id="canceled" onclick="setActiveTab(event, this)" >{{__('messages.cancelled')}} </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="{{ route('meetings.rejected') }}" id="rejected" onclick="setActiveTab(event, this)" >{{__('messages.rejected')}} </a>
                </li>
                    <!-- Add more tabs if needed -->
            </ul>
        
            

            <div class="card-body" id="employeeTableContainer">
                    @include('admin.meeting.meeting_table', ['meeting' => $meetings])
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
</script>