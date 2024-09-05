<?php

namespace App\Http\Controllers;

use App\Jobs\SendMeetingNotifications;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Participant;
use DataTables;
use App\Http\Controllers\FCMPushController;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Exports\MeetingDataExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\MeetingValidationService;
use App\Notifications\MeetingInvitation;


class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $notificationController;
     protected $meetingValidationService;

    public function __construct(FCMPushController $notificationController, MeetingValidationService $meetingValidationService)
    {
        $this->notificationController = $notificationController;
        $this->meetingValidationService = $meetingValidationService;
    }

     

     public function index()
     {
        
        $meetings = $this->queryDataList();

        // Update booking status based on conditions
        $today = now()->toDateString();
        foreach ($meetings as $meeting) {
            $status = $meeting->booking_status;
            $startDate = $meeting->start_date;

            switch ($status) {
                case 'pending':
                    if ($startDate < $today) {
                        $status = 'expired';
                    }
                    break;
                case 'accepted':
                    if ($startDate < $today) {
                        $status = 'completed';
                    } else {
                        $status = 'upcoming';
                    }
                    break;
                // case 'rejected':
                //     $status = 'canceled';
                //     break;
            }

            // Update the meeting status
            $meeting->booking_status = $status;
        }

         // Order meetings by latest start_date
        $meetings = $meetings->sortByDesc('start_date')->values()->all();
        // $meetings = $meetings->sortBy('start_date')->values()->all();

   
        return view('admin.meeting.index', compact('meetings'));

     }

    public function upcoming(Request $request)
    {
        $meetings = $this->queryDataList();
        // Determine today's date
        $today = now()->toDateString();

        // Filter meetings and calculate statuses
        $meetings = $meetings->filter(function ($meeting) use ($today) {
            return $meeting->booking_status === 'accepted' && $meeting->start_date >= $today;
        });

        $meetings = $meetings->sortBy('start_date')->values()->all();

        return view('admin.meeting.upcoming', compact('meetings'));
    }

    public function pending()
    {
        $meetings = $this->queryDataList();

        // Determine today's date
        $today = now()->toDateString();


        $meetings = $meetings->filter(function ($meeting) use ($today) {
            return $meeting->booking_status === 'pending' && $meeting->start_date >= $today;
        });

        $meetings = $meetings->sortBy('start_date')->values()->all();


        return view('admin.meeting.pending', compact('meetings'));
    }


    public function rejected()
    {

        $meetings = $this->queryDataList();

        $meetings = $meetings->filter(function ($meeting) {
            return $meeting->booking_status === 'rejected';
        });

         // Order meetings by latest start_date
        $meetings = $meetings->sortByDesc('start_date')->values()->all();
   

        return view('admin.meeting.rejected', compact('meetings'));
    }
    public function cenceled()
    {

        $meetings = $this->queryDataList();

        $today = now()->toDateString();

        $meetings = $meetings->filter(function ($meeting) use ($today) {
            return $meeting->booking_status === 'pending' && $meeting->start_date < $today;
        });

        // update booking status base on condition
        foreach ($meetings as $meeting) {
            $status = $meeting->booking_status;
           
            switch ($status) {
                case 'pending': 
                     $status = 'expired';
                    
                    break;
            }

            // Update the meeting status
            $meeting->booking_status = $status;
        }

         // Order meetings by latest start_date
        $meetings = $meetings->sortByDesc('start_date')->values()->all();
   

        return view('admin.meeting.canceled', compact('meetings'));
    }


    public function completed()
    {
        $meetings = $this->queryDataList();
        // Determine today's date
        $today = now()->toDateString();

        $meetings = $meetings->filter(function ($meeting) use ($today) {
            return $meeting->booking_status === 'accepted' && $meeting->start_date < $today;
        });

        return view('admin.meeting.index', compact('meetings'));
    }


    private function queryDataList()
    {
        // Retrieve the authenticated user's employee ID and role ID
        $employeeId = Auth()->user()->employee_id;
        $roleId = Auth()->user()->role_id;

        // Fetch meetings based on user role
        $meetingsQuery = Meeting::with('participants');
        if ($roleId !== 1) {
            $meetingsQuery->where(function ($query) use ($employeeId) {
                $query->where('host_id', $employeeId)
                    ->orWhereHas('participants', function ($query) use ($employeeId) {
                        $query->where('participant_id', $employeeId);
                    });
            });
        }

        $meetings = $meetingsQuery->get();

        return $meetings;

    }



     // get all meeting for Mobile App
    public function getAllMeetins(Request $request)
    {
       // Retrieve the employee ID from the request query
        $employeeId = $request->query('employee_id');

        // Retrieve the user based on the employee ID
        $user = User::where('employee_id', $employeeId)->first();

        $meetingsQuery = Meeting::with('participants');

        // Check if the user exists and is an admin (role_id = 1)
        if ($user && $user->role_id !== 1) {
            // For non-admin users, add additional conditions to the query
            $meetingsQuery->where(function ($query) use ($employeeId) {
                $query->where('host_id', $employeeId)
                    ->orWhereHas('participants', function ($query) use ($employeeId) {
                        $query->where('participant_id', $employeeId);
                    });
            });
        }

        // Execute the query to get the meetings
        $meetings = $meetingsQuery->get();

        $data = $meetings->map(function ($meeting) {

            // Determine the status based on conditions
            $status = $meeting->booking_status;
            $today = now()->toDateString();
            $startDate = $meeting->start_date;

            if ($status === 'pending') {
                if ($startDate < $today) {
                    $status = 'expired';
                } 
            } elseif ($status === 'accepted') {
                if ($startDate < $today) {
                    $status = 'completed';
                } else {
                    $status = 'upcoming';
                }
            } 
            // elseif ($status === 'rejected') {
            //         $status = 'canceled';
            // } 

            return [
                'id' => $meeting->id,
                'room_id' => $meeting->room_id,
                'room_name' => $meeting->room->name,
                'room_facilities' => $meeting->room->facilities,
                'meeting_title' => $meeting->meeting_title,
                'start_date' => $meeting->start_date,
                'start_time' => $meeting->start_time,
                'end_time' => $meeting->end_time,
                'host_id' => $meeting->host_id,
                'host_name' => $meeting->host ? $meeting->host->name : '',
                'co_host_id' => $meeting->co_host_id ? $meeting->co_host_id : 0,
                'co_host_name' => $meeting->coHost ? $meeting->coHost->name : '',
                'booking_type' => $meeting->booking_type,
                'booking_status' => $status,
                'location' => $meeting->room->location,
                'created_at' => $meeting->created_at,
                'updated_at' => $meeting->updated_at,
                'participants' => $meeting->participants->map(function ($participant) {
                    return [
                        'id' => $participant->id,
                        'meeting_id' => $participant->meeting_id,
                        'participant_id' => $participant->participant_id,
                        'participant_name' => $participant->employee ? $participant->employee->name : '',
                        'division' => $participant->employee ? $participant->employee->division : '',
                        'designation' => $participant->employee ? $participant->employee->designation : '',
                        'created_at' => $participant->created_at,
                        'updated_at' => $participant->updated_at,
                    ];
                }),
            ];
        });
       
         // Order meetings by latest start_date
        $data = $data->sortByDesc('start_date')->values()->all();
   
        return response()->json([
            'status_code' => Response::HTTP_OK,
            'data' => $data,
            'message' => 'Success'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.meeting.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        
        $validator = $this->meetingValidationService->validateMeeting($request);

        
            // If validation fails, return a custom response
        if ($validator->fails()) {
          return  redirect()->back()->with('error', $validator->errors()->first()); 
        
        }
        

        // If validation passes, create the meeting using the validated data
        $meeting = Meeting::create($validator->validated());

       
        // Attach participants to the meeting
        $participants = $request->input('participants', []);

        // Include host and co-host in participants if they are selected
        if ($request->has('host_id')) {
            $participants[] = $request->input('host_id');
        }
        if ($request->has('co_host_id') && $request->input('co_host_id')) {
            $participants[] = $request->input('co_host_id');
        }

        $participants = array_unique($participants);
        
        foreach ($participants as $participantId) {
            // Create a new participant record
            Participant::create([
                'meeting_id' => $meeting->id,
                'participant_id' => $participantId
            ]);
        }

        $devicesToken = User::where('role_id', 1)->pluck('device_token')->toArray();

        $this->notificationController->attemtNotification($devicesToken, "Created a Meeting", "Requested to you a meeting schedule.");

        
        // sent the notification to user admin
       
        // // Fetch all users with role_id 1
        // $userEmails = User::where('role_id', 1)->pluck('email')->toArray();

        // // Loop through each email, fetch the user and send the notification
        // foreach ($userEmails as $email) {
        //     $user = User::where('email', $email)->first();

        //     if ($user) {
        //         $user->notify(new MeetingInvitation(
        //             $meeting->id,
        //             $meeting->meeting_title,
        //             $meeting->start_date,
        //             $meeting->start_time,
        //             $meeting->end_time,
        //             $meeting->room->name . ' at ' . $meeting->room->location
        //         ));
        //     }
        // }



        // Prepare meeting details for the job
        $meetingDetails = [
            'id' => $meeting->id,
            'title' => $meeting->meeting_title,
            'start_date' => $meeting->start_date,
            'start_time' => $meeting->start_time,
            'end_time' => $meeting->end_time,
            'location' => $meeting->room->name . ' at ' . $meeting->room->location
        ];

        // Dispatch the job to send notifications
        SendMeetingNotifications::dispatch($meeting, $meetingDetails);



        return redirect()->route("meeting.index")->with('message', 'Meeting created successfully');


    }


     // create meeting by APP
     public function createMeeting(Request $request)
     {
 
         $validator = $this->meetingValidationService->validateMeeting($request);
 
         
             // If validation fails, return a custom response
         if ($validator->fails()) {
             return response()->json([
                 'message' => $validator->errors()->first(),
                 'status_code' => 422
             ], 200);
         }
 
         // If validation passes, create the meeting using the validated data
         $meeting = Meeting::create($validator->validated());
 
        
          // Attach participants to the meeting
          $participants = $request->input('participants', []);
  
          // Include host and co-host in participants if they are selected
          if ($request->has('host_id')) {
              $participants[] = $request->input('host_id');
          }
          if ($request->has('co_host_id') && $request->input('co_host_id')) {
              $participants[] = $request->input('co_host_id');
          }

          $participants = array_unique($participants);
  
          foreach ($participants as $participantId) {
              // Create a new participant record
              Participant::create([
                  'meeting_id' => $meeting->id,
                  'participant_id' => $participantId
              ]);
          }
 
 
         // sent the notification to user admin
         $devicesToken = User::where('role_id', 1)->pluck('device_token')->toArray();
 
         $this->notificationController->attemtNotification($devicesToken, "Created a Meeting", "Requested to you a meeting schedule.");
 
 
         // Return a success response with the created meeting
             return response()->json([
                 'status_code' => 200,
                 'message' => 'Meeting created successfully',
                 //'meeting' => $meeting,
             ], 200);
     }
 


    // filter meeting for web

    public function searchMeeting(Request $request)
    {


        $employeeId = auth()->user()->employee_id;
        $roleId = auth()->user()->role_id;

        // Fetch meetings based on user role
        $meetingsQuery = Meeting::with('participants');
        if ($roleId !== 1) {
            $meetingsQuery->where(function ($query) use ($employeeId) {
                $query->where('host_id', $employeeId)
                    ->orWhereHas('participants', function ($query) use ($employeeId) {
                        $query->where('participant_id', $employeeId);
                    });
            });
        }

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->search;
            $meetingsQuery->where(function ($query) use ($search) {
                $query->where('meeting_title', 'like', '%' . $search . '%')
                    ->orWhere('start_date', 'like', '%' . $search . '%')
                    ->orWhere('booking_status', 'like', '%' . $search . '%')
                    ->orWhere('booking_type', 'like', '%' . $search . '%');
            });
        }

        
        // Apply date filter based on selected value
        if ($request->has('filter')) {
            
            $filter = $request->input('filter');
            $dateFrom = now();

            
            switch ($filter) {
                case '1':
                    $dateFrom = now()->subDays(15);
                    break;
                case '2':
                    $dateFrom = now()->subDays(30);
                    break;
                case '3':
                    $dateFrom = now()->subDays(90);
                    break;
                case '4':
                    $dateFrom = now()->subDays(180);
                    break;
                default:
                    $dateFrom = null;
            }

            if ($dateFrom) {
                $formattedDateFrom = $dateFrom->toDateString();
                $meetingsQuery->whereDate('start_date', '>=', $formattedDateFrom);

               
            }

        }


    
        // Get paginated results
        $meetings = $meetingsQuery->orderBy('start_date')->paginate(30);

        
        // Update booking status based on conditions
        $today = now()->toDateString();
        foreach ($meetings as $meeting) {
            $status = $meeting->booking_status;
            $startDate = $meeting->start_date;

            switch ($status) {
                case 'pending':
                    if ($startDate < $today) {
                        $status = 'expired';
                    }
                    break;
                case 'accepted':
                    if ($startDate < $today) {
                        $status = 'completed';
                    } else {
                        $status = 'upcoming';
                    }
                    break;
                // case 'rejected':
                //     $status = 'canceled';
                //     break;
            }

            // Update the meeting status
            $meeting->booking_status = $status;
        }


        if ($request->ajax()) {
            return view('admin.meeting.meeting_table', compact('meetings'))->render();
        }

        return view('admin.meeting.index', compact('meetings'));
    }


    public function getMeetingsByDate(Request $request)
    {
        $date = $request->query('start_date');
        $room_id = $request->input('room_id');


        // Parse the provided date string into a Carbon instance
        $parsedDate = Carbon::parse($date);

        // Retrieve meetings for the specified date
        $meetings;

        if($room_id != null) {
            $meetings = Meeting::with(['participants.employee', 'host', 'coHost'])
            ->where('room_id', $room_id)
            ->where('booking_status', '!=', 'rejected') // New condition
            ->whereDate('start_date', $parsedDate)
            ->get();
        } else {
            $meetings = Meeting::with(['participants.employee', 'host', 'coHost'])
            ->where('booking_status', '!=', 'rejected') // New condition
            ->whereDate('start_date', $parsedDate)
            ->get();
        }
       
        // Transform the meetings data (similar to the previous API endpoint)
        $data = $meetings->map(function ($meeting) {
            return [
                'id' => $meeting->id,
                'room_id' => $meeting->room_id,
                'room_name' => $meeting->room->name,
                'room_location' => $meeting->room->location,
                'meeting_title' => $meeting->meeting_title,
                'start_date' => $meeting->start_date,
                'start_time' => $meeting->start_time,
                'end_time' => $meeting->end_time,
                'host_id' => $meeting->host_id,
                'host_name' => $meeting->host ? $meeting->host->name : "",
                'co_host_id' => $meeting->co_host_id ?  $meeting->co_host_id : 0,
                'co_host_name' => $meeting->coHost ? $meeting->coHost->name : "",
                'booking_type' => $meeting->booking_type,
                'booking_status' => $meeting->booking_status,
                'created_at' => $meeting->created_at,
                'updated_at' => $meeting->updated_at,
                
            ];
        });

        // Return the JSON response
        return response()->json([
            'status_code' => Response::HTTP_OK,
            'data' => $data,
            'message' => 'Success'
        ]);
    }

   

    public function dashboardMeetingCount() {
        $today = Carbon::today();

        $totalMeeting = Meeting::all()->count();

        $upcomingCount = Meeting::where('booking_status', 'accepted')
        ->whereDate('start_date', '>=', $today) // Start date on or after today
        ->count();
       
        $pendingCount = Meeting::where('booking_status', 'pending')
        ->whereDate('start_date', '>=', $today) // Start date on or after today
        ->count();

        //$pendingCount = Meeting::whereIn('booking_status', ['pending', 'rejected'])->count();

        $rejectedCount = Meeting::where('booking_status', 'rejected')->count();

        $expiredCount = Meeting::where('booking_status', 'pending')
        ->whereDate('start_date', '<', $today) // Start date before today
        ->count();


        $completedCount = Meeting::where('booking_status', 'accepted')
        ->whereDate('start_date', '<', $today) // Start date before today
        ->count();
       
        // Get the start date of the current week (Sunday)
        $startOfWeek = Carbon::now()->startOfWeek()->subDay()->format('Y-m-d');

        // Get the end date of the current week (Saturday)
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
        
        // Get the start and end dates of the current year
        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d');
        $endOfYear = Carbon::now()->endOfYear()->format('Y-m-d');
        
        // Get meetings for the current week and current year
        $weeklyMeetings = Meeting::whereBetween('start_date', [$startOfWeek, $endOfWeek])->get();
        $yearlyMeetings = Meeting::whereBetween('start_date', [$startOfYear, $endOfYear])->get();
        
        // Initialize the weekend data array
        $weekendData = [
            'Sunday' => 0,
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
        ];

        // Initialize the yearly data array
        $yearlyData = [
            'Jan' => 0,
            'Feb' => 0,
            'Mar' => 0,
            'Apr' => 0,
            'May' => 0,
            'Jun' => 0,
            'Jul' => 0,
            'Aug' => 0,
            'Sep' => 0,
            'Oct' => 0,
            'Nov' => 0,
            'Dec' => 0
        ];

        // Populate the weekendData array
        foreach ($weeklyMeetings as $meeting) {
            // Extract the day of the week from the start date
            $weekDay = Carbon::parse($meeting->start_date)->format('l');
            $weekendData[$weekDay]++;
        }

        // Populate the yearlyData array
        foreach ($yearlyMeetings as $meeting) {
            // Extract the month from the start date
            $month = Carbon::parse($meeting->start_date)->format('M');
            $yearlyData[$month]++;
        }
        return view('welcome', compact('totalMeeting', 'upcomingCount', 'pendingCount', 'completedCount', 'rejectedCount', 'expiredCount', 'weekendData', 'yearlyData'));

    }

   

    public function getSummary()
    {
    
            // Get today's date
        $today = Carbon::today();

        // Get count of meetings with different statuses
        $upcomingCount = Meeting::where('booking_status', 'accepted')
            ->whereDate('start_date', '>=', $today) // Start date on or after today
            ->count();

        $pendingCount = Meeting::where('booking_status', 'pending')->count();

        $completedCount = Meeting::where('booking_status', 'accepted')
            ->whereDate('start_date', '<', $today) // Start date before today
            ->count();

        // Total meeting count
        $totalMeetingCount = Meeting::count();

        
        // Get the start date of the current week (Sunday)
        $startOfWeek = Carbon::now()->startOfWeek()->subDay()->format('Y-m-d');

        // Get the end date of the current week (Saturday)
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        // Get count of meetings for the current week
        $meetings = Meeting::whereBetween('start_date', [$startOfWeek, $endOfWeek])->get();



        // Initialize the weekend data array
        $weekendData = [
            'Sunday' => 0,
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
        ];

        foreach ($meetings as $meeting) {
            // Extract the day of the week from the start date
            $weekDay = Carbon::parse($meeting->start_date)->format('l');
    
            // Increment the count for the respective day of the week
            $weekendData[$weekDay]++;
        }
    
        // Return the summary data
        $data = [
            'total_meeting' => $totalMeetingCount,
            'upcoming' => $upcomingCount,
            'pending' => $pendingCount,
            'completed' => $completedCount,
            'weekly_schedule' => $weekendData,
        ];

        return response()->json([
            'status_code' => Response::HTTP_OK,
            'data' => $data,
            'message' => 'Success'
        ]);
    }
    
    
    public function updateMeetingStatus(Request $request, $id)
    {

       // Validate the incoming request data
       $validator = Validator::make($request->all(), [
        'booking_status' => 'required|in:accepted,completed,rejected',
       // 'booking_type' => 'required|in:booked,rescheduled',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $message = implode('. ', $errors);
            return response()->json(['status_code' => 422, 'message' => $message], 200);
        }

         // Find the meeting record by ID
        $meeting = Meeting::find($id);

        // Check if the meeting exists
        if (!$meeting) {
            return response()->json(['status_code' => 404, 'message' => 'Meeting not found'], 200);
        }

        // Update the meeting record with the validated data
        $meeting->update([
            'booking_status' => $request->booking_status,
        ]
       );


        // sent the notification to user host and co-host
      
       $hostId = $meeting->host_id;
       $coHostId = $meeting->co_host_id;

       $users = User::whereIn('employee_id', [$hostId, $coHostId])->get();

       // Extract api_tokens from the user records
       $devicesToken = $users->pluck('device_token')->toArray();
    
       $this->notificationController->attemtNotification($devicesToken, "Meeting Updated", "Your meeting has been " . $request->booking_status);
 

        // Return a success response
        return response()->json(['status_code' => 200, 'message' => 'Meeting status updated successfully']);

    }


    public function updateMeetingByWeb(Request $request, $id)
    {

       // Validate the incoming request data
       $validator = Validator::make($request->all(), [
        'booking_status' => 'required|in:accepted,completed,rejected',
       // 'booking_type' => 'required|in:booked,rescheduled',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $message = implode('. ', $errors);

            return  redirect()->back()->with('error', $message); 

        }

         // Find the meeting record by ID
        $meeting = Meeting::find($id);

        // Check if the meeting exists
        if (!$meeting) {
            return  redirect()->back()->with('error', 'Meeting not found'); 

        }

        // Update the meeting record with the validated data
        $meeting->update([
            'booking_status' => $request->booking_status,
        ]
       );


        // sent the notification to user host and co-host
      
       $hostId = $meeting->host_id;
       $coHostId = $meeting->co_host_id;

       $users = User::whereIn('employee_id', [$hostId, $coHostId])->get();

       // Extract api_tokens from the user records
       $devicesToken = $users->pluck('device_token')->toArray();
    
       $this->notificationController->attemtNotification($devicesToken, "Meeting Updated", "Your meeting has been " . $request->booking_status);
 
        // Return a success response
        return redirect()->back()->with('message', 'Meeting status updated successfully');

    }



    public function reschedule(Request $request, $id)
        {

            $meeting = Meeting::find($id);

             // Check if the meeting exists
            if (!$meeting) {
                return response()->json(['status_code' => 404, 'message' => 'Meeting not found'], 200);
            }
            
            $validator = $this->meetingValidationService->validateMeetingUpdate($request, $meeting);

            // $validator = $this->meetingValidationService->validateMeeting($request);


            // If validation fails, return a custom response
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status_code' => 422
                ], 200);
            }

           
            $meeting->update($validator->validated());


            $apiToken = $request->query('api_token');

            // Retrieve the user based on the employee ID
            $user = User::where('api_token', $apiToken)->first();
    
            // Check if the user exists and is an admin (role_id = 1)
            if ($user && $user->role_id === 1) {
                $meeting->update(['booking_status' => 'accepted']);
            } else {
                $meeting->update(['booking_status' => 'pending']);
            }

             // Update booking type to 'reschedule'
             $meeting->update(['booking_type' => 'reschedule']);

           

            // Update or attach participants to the meeting
            if ($request->has('participants')) {
                $meeting->updateParticipants()->sync($request->participants);
                $meeting->participants()->get()->each->touch();

            }

            // sent the notification to user admin
            $devicesToken = User::where('role_id', 1)->pluck('device_token')->toArray();

            $this->notificationController->attemtNotification($devicesToken, "Reschedule a Meeting", "Requested to you a meeting re-schedule.");
    
            
            // Return a successful response with the updated meeting
            return response()->json([
                'status_code' => 200,
                'message' => 'Meeting updated successfully',
                //'meeting' => $meeting,
            ], 200);
        }
   


   
    public function edit($id)
    {
        $meeting = Meeting::with('participants')->find($id);
        $activeEmployees = Employee::where('status', 'active')->get();
    
        return view('admin.meeting.edit', compact('meeting', 'activeEmployees'));
    }
    

    public function update(Request $request, $id)
    
    {

        $meeting = Meeting::find($id);

         // Check if the meeting exists
         if (!$meeting) {
            
            return  redirect()->back()->with('error', 'Meeting not found'); 
    
        }
           
        $validator = $this->meetingValidationService->validateMeetingUpdate($request, $meeting);
    
        // If validation fails, return a custom response
        if ($validator->fails()) {
            return  redirect()->back()->with('error', $validator->errors()->first()); 
        }

        $meeting->update($validator->validated());

        
        // Check if the user exists and is an admin (role_id = 1)
        if (Auth()->user()->role_id === 1) {
            $meeting->update(['booking_status' => 'accepted']);
        } else {
            $meeting->update(['booking_status' => 'pending']);
        }
            // Update booking type to 'reschedule'
            $meeting->update(['booking_type' => 'reschedule']);
        

    

        // Update or attach participants to the meeting
        if ($request->has('participants')) {
            $meeting->updateParticipants()->sync($request->participants);
            $meeting->participants()->get()->each->touch();

        }

         // sent the notification to user admin
         $devicesToken = User::where('role_id', 1)->pluck('device_token')->toArray();

         $this->notificationController->attemtNotification($devicesToken, "Reschedule a Meeting", "Requested to you a meeting re-schedule.");
 
         
                
        return redirect()->route("meeting.index")->with('message', 'Meeting rescheduled successfully');

    }


    public function exportExcel(Request $request)
    {

        $meetings = $this->getFilteredMeetings($request);

        return Excel::download(new MeetingDataExport($meetings), 'meetings-data.xlsx');
    }


    public function exportMeetingPdf(Request $request)
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 300);

        $meetings = $this->getFilteredMeetings($request);


        $html = '
        <html>
        <head>
            <style>
                body { font-family: sans-serif; margin: 20px; }
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid black; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .page-break { page-break-after: always; }
            </style>
        </head>
        <body>
            <h1>Meetings List</h1>
            <table>
                <thead>
                    <tr>
                        <th>Meeting ID</th>
                        <th>Room Name</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Host</th>
                        <th>Co-Host</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Participants</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($meetings as $meeting) {
            $participants = $meeting->participants->map(function ($participant) {
                return $participant->employee ? 
                    "{$participant->employee->name} ({$participant->employee->division})" 
                    : '';
            })->implode(', ');

            $html .= '<tr>';
            $html .= '<td>' . $meeting->id . '</td>';
            $html .= '<td>' . ($meeting->room ? $meeting->room->name : 'N/A') . '</td>';
            $html .= '<td>' . $meeting->meeting_title . '</td>';
            $html .= '<td>' . $meeting->start_date . '</td>';
            $html .= '<td>' . $meeting->start_time . '</td>';
            $html .= '<td>' . $meeting->end_time . '</td>';
            $html .= '<td>' . ($meeting->host ? $meeting->host->name : 'N/A') . '</td>';
            $html .= '<td>' . ($meeting->coHost ? $meeting->coHost->name : 'N/A') . '</td>';
            $html .= '<td>' . $meeting->booking_type . '</td>';
            $html .= '<td>' . $meeting->booking_status . '</td>';
            $html .= '<td>' . $meeting->description . '</td>';
            $html .= '<td>' . $participants . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table></body></html>';


         // Set paper size and margins
        $pdf = Pdf::loadHTML($html)
        ->setPaper('a4', 'landscape')
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 96,
            'defaultFont' => 'sans-serif',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);
        return $pdf->download('employees-pdf-export.pdf');

    }  


    public function exportMeetingCsv(Request $request)
    {
        
        $meetings = $this->getFilteredMeetings($request);

        $csvHeader = [
            'Meeting ID', 
            'Room Name', 
            'Title', 
            'Date', 
            'Start Time', 
            'End Time', 
            'Host', 
            'Co-Host', 
            'Type', 
            'Status', 
            'Description', 
            'Participants'
        ];
        
        $csvData = [];

        foreach ($meetings as $meeting) {
            $participants = $meeting->participants->map(function ($participant) {
                return $participant->employee ? 
                    "{$participant->employee->name} (Division: {$participant->employee->division}, Designation: {$participant->employee->designation})" 
                    : '';
            })->implode(', ');

            $csvData[] = [
                $meeting->id,
                $meeting->room ? $meeting->room->name : 'N/A',
                $meeting->meeting_title,
                $meeting->start_date,
                $meeting->start_time,
                $meeting->end_time,
                $meeting->host ? $meeting->host->name : 'N/A',
                $meeting->coHost ? $meeting->coHost->name : 'N/A',
                $meeting->booking_type,
                $meeting->booking_status,
                $meeting->description,
                $participants
            ];
        }

        $filename = 'meetings-csv-export.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, $csvHeader);

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }


    public function printView(Request $request)
    {
        $meetings = $this->getFilteredMeetings($request);

        return view('admin.meeting.print', compact('meetings'));
    }


    private function getFilteredMeetings(Request $request)
    {
        $employeeId = Auth()->user()->employee_id;
        $roleId = Auth()->user()->role_id;
        $filter = $request->input('filter', '0'); // Default to '0' if no filter is provided

        $meetingsQuery = Meeting::with(['room', 'host', 'coHost', 'participants.employee'])
            ->select(
                'id', 
                'room_id', 
                'meeting_title', 
                'start_date', 
                'start_time', 
                'end_time', 
                'host_id', 
                'co_host_id', 
                'booking_type', 
                'booking_status', 
                'description'
            );

        if ($roleId !== 1) {
            $meetingsQuery->where(function ($query) use ($employeeId) {
                $query->where('host_id', $employeeId)
                    ->orWhereHas('participants', function ($query) use ($employeeId) {
                        $query->where('participant_id', $employeeId);
                    });
            });
        }

        // Apply date filter based on selected value
        $dateFrom = now();
        switch ($filter) {
            case '1':
                $dateFrom = now()->subDays(15);
                break;
            case '2':
                $dateFrom = now()->subDays(30);
                break;
            case '3':
                $dateFrom = now()->subDays(90);
                break;
            case '4':
                $dateFrom = now()->subDays(180);
                break;
            default:
                $dateFrom = null;
        }

        if ($dateFrom) {
            $meetingsQuery->whereDate('start_date', '>=', $dateFrom);
        }

        return $meetingsQuery->get();
    }



    public function getMeetingDataById(Request $request, $id)
    {

         // Find the meeting record by ID
        $meeting = Meeting::find($id);

        //dd($meeting);

        return view('admin.meeting.meeting_view', compact('meeting'));

    }
}
