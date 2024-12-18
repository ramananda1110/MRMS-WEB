 <table id="meetingTable" class="table table-striped table-bordered mt-5">
     <!-- <table id="datatablesSimple" class="table table-striped table-bordered"> -->

     <thead>
         <tr>

             <th scope="col">SN</th>
             <th scope="col">Room Name</th>
             <th scope="col">Meeting Title</th>
             <th scope="col">Date</th>
             <th scope="col">Duration</th>
             <th scope="col">Status</th>

             <th scope="col">Action</th>

         </tr>
     </thead>
     <tbody>

         @if (count($meetings) > 0)
             @foreach ($meetings as $key => $meeting)
                 <tr>
                       
                     <td>{{ $key + 1 }}</td>
                     <th scope="row">{{ $meeting->room->name }}</th>
                     <td>{{ $meeting->meeting_title }}</td>
                     <td>{{ \Carbon\Carbon::parse($meeting->start_date)->format('F j, Y') }}</td>
                     <td>{{ DateTime::createFromFormat('H:i:s', $meeting->start_time)->format('h:i A') }} -
                         {{ DateTime::createFromFormat('H:i:s', $meeting->end_time)->format('h:i A') }}</td>
                     @if ($meeting->booking_status == 'accepted')
                         <td class="text-center"><span
                                 class="badge rounded-pill badge-primary bg-success">{{ $meeting->booking_status }}</span>
                         </td>
                     @elseif($meeting->booking_status == 'rejected')
                         <td class="text-center"><span
                                 class="badge rounded-pill badge-primary bg-danger">{{ $meeting->booking_status }}</span>
                         </td>
                     @elseif($meeting->booking_status == 'expired')
                         <td class="text-center"><span
                                 class="badge rounded-pill badge-primary bg-warning text-dark">{{ $meeting->booking_status }}</span>
                         </td>
                     @else
                         <td class="text-center"><span
                                 class="badge rounded-pill badge-primary bg-primary">{{ $meeting->booking_status }}</span>
                         </td>
                     @endif

                     <td>
                         @if (isset(Auth()->user()->role->permission['name']['meeting']['can-view']))
                             <a href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $meeting->id }}"
                                 title="View">
                                 <button type="button" class="btn btn-primary"><i
                                         class="fa-solid fa-eye"></i></button></a>
                         @endif
                         
                        @if ($meeting->booking_status == 'pending')
                            @if (isset(Auth()->user()->role->permission['name']['meeting']['can-edit']))
                                <a data-bs-toggle="modal" data-bs-target="#acceptModal{{ $meeting->id }}",
                                    href="#" title="Accept">
                                    <button type="button" class="btn btn-success"><i
                                            class="fa-regular fa-square-check"></i></button></a>
                            @endif


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
                                                 <input type="hidden" name="booking_status" id="accept_booking_status">
                                                 <button class="btn btn-outline-success"
                                                     onclick="submitForm('accepted', 'acceptMeetingForm{{ $meeting->id }}')">
                                                     Accept
                                                 </button>
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                             </div>


                             {{-- -------------------------------------------------------------------------------------------------- --}}
                             @if (isset(Auth()->user()->role->permission['name']['meeting']['can-reschedule']))
                            
                             <a href="{{ route('meeting.edit', [$meeting->id]) }}" title="Re-schedule">
                                 <button type="button" class="btn btn-warning"><i
                                         class="fa-solid fa-calendar-days"></i></button></a>

                             @endif

                             @if (isset(Auth()->user()->role->permission['name']['meeting']['can-edit']))
                                 <a data-bs-toggle="modal" data-bs-target="#rejectModal{{ $meeting->id }}",
                                     href="#" title="Reject">
                                     <button type="button" class="btn btn-danger"><i
                                             class="fa-solid fa-ban"></i></button> </a>
                             @endif


                             <div class="modal fade" id="rejectModal{{ $meeting->id }}" tabindex="-1"
                                 aria-labelledby="rejectModalLabel" aria-hidden="true">
                                 <div class="modal-dialog">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h1 class="modal-title fs-5" id="rejectModalLabel">Confirm!</h1>
                                             <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                 aria-label="Close"></button>
                                         </div>
                                         <div class="modal-body">

                                             Are you sure? do you want to reject meeting?


                                         </div>
                                         <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary"
                                                 data-bs-dismiss="modal">Close</button>
                                             <form id="rejectMeetingForm{{ $meeting->id }}"
                                                 action="{{ route('meeting.update.web', [$meeting->id]) }}"
                                                 method="post">@csrf
                                                 <input type="hidden" name="booking_status" id="reject_booking_status">
                                                 <button class="btn btn-outline-danger"
                                                     onclick="submitForm('rejected', 'rejectMeetingForm{{ $meeting->id }}')">
                                                     REJECT
                                                 </button>
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         @endif

                         <div class="modal fade" id="viewModal{{ $meeting->id }}" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog">
                                 <form>@csrf
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h1 class="modal-title fs-5" id="exampleModalLabel">Meeting Details</h1>
                                             <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                 aria-label="Close"></button>
                                         </div>
                                         <div class="modal-body">
                                             <div class="card">
                                                 <div class="card-body">
                                                     <table class="table">
                                                         <tbody>

                                                             <tr>
                                                                 <th>Meeting Title</th>
                                                                 <td>{{ $meeting->meeting_title }}</td>
                                                             </tr>
                                                             <tr>
                                                                 <th>Room Name</th>
                                                                 <td>{{ $meeting->room->name }}</td>
                                                             </tr>
                                                             <tr>
                                                                 <th>Room Location</th>
                                                                 <td>{{ $meeting->room->location }}</td>
                                                             </tr>
                                                             <tr>
                                                                 <th>Start Date</th>
                                                                 <td>{{ \Carbon\Carbon::parse($meeting->start_date)->format('F j, Y') }}
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <th>Start Time</th>
                                                                 <td>{{ DateTime::createFromFormat('H:i:s', $meeting->start_time)->format('h:i A') }}
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <th>End Time</th>
                                                                 <td>{{ DateTime::createFromFormat('H:i:s', $meeting->end_time)->format('h:i A') }}
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <th>Host Name</th>
                                                                 <td>{{ $meeting->host->name }}</td>
                                                             </tr>
                                                             <tr>
                                                                 <th>Co-Host Name</th>
                                                                 <td>{{ $meeting->coHost->name ?? 'N/A' }}</td>
                                                             </tr>
                                                             <tr>
                                                                 <th>Participants Name</th>
                                                                 <td>
                                                                     @foreach ($meeting->participants as $index => $participant)
                                                                         {{ $participant->employee->name }}
                                                                         @if ($index < count($meeting->participants) - 1)
                                                                             ,
                                                                         @endif
                                                                     @endforeach
                                                                     {{-- {{ $meeting->participants }} --}}
                                                                 </td>
                                                             </tr>
                                                             <tr>
                                                                 <th>Status</th>
                                                                 <td>{{ $meeting->booking_status }}</td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary"
                                                 data-bs-dismiss="modal">Close</button>
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
             <tr>
                 <td colspan="7" class="text-center">No meeting found!</td>
             </tr>

         @endif
     </tbody>
 </table>
