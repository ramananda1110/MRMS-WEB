<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Exports\UserDataExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'project_code'=>'required',
            'firstname'=>'required',
            'lastname'=>'required',
            'employee_id'=>'required',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string',
            'department_id'=>'required',
            'role_id'=>'required',
            'image'=>'mimes:jpeg,jpg,png',
            'start_from'=>'required',
            'designation'=>'required'
        ]);
      
        
        $data = $request->all();
        //dd($data);
          
        if($request->hasFile('image')){
            $image = $request->image->hashName();
            $request->image->move(public_path('profile'), $image);
        }else {
            $image = 'avatar2.png';
        }

        $data['name'] = $request->firstname.' '.$request->lastname;
        $data['image'] = $image;
        $data['password'] = bcrypt($request->password);
        $data['department_id'] = $request->department_id;
        $data['role_id'] = $request->role_id;

        User::create($data);
        return redirect()->back()->with('message', 'User Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

       

        $data = $request->all();
       
        $user = User::find($id);
       
        if($request->hasFile('image')){
            $image = $request->image->hashName();
            $request->image->move(public_path('profile'), $image);
        } else {
            $image = $user->image;
        }

        if($request->password){
            $password = $request->password;
        } else {
            $password = $user->password;
        }

        $data['image'] = $image;
        $data['password'] = bcrypt($password);
        $data['name'] = $request->name;
        $data['department_id'] = $request->department_id;
        $data['role_id'] = $request->role_id;

        $user->update($data);
        
        return redirect()->route("users.index")->with('message', 'User Record Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('message', 'Recored  Deleted');

    }

    public function listOfUser() {
       //$dataList = User::all();
       // return response()->json($dataList);
       //return $department = Department::with('user')->get();

       return User::all();
    }

    public function userInfo(Request $request)
    {
       
        $apiToken = $request->query('api_token');

        $user = User::where('api_token', $apiToken)->first();

        // Attempt to authenticate the user
        if ($user) {
           
            // Make department_id and role_id hidden in the JSON response
            $user->makeHidden(['department_id', 'role_id']);

            // Return the user data and the token in the response
            return response()->json([
                'status_code' => Response::HTTP_OK,
                'user' => array_merge($user->toArray(), [
                    'is_admin' => $user->isAdmin(),
                    'api_token' => $apiToken,
                    'department_name' => optional($user->department)->name,
                    'role' => optional($user->role)->name,
                ]),
                'message' => 'Success'
            ]);
        }

        // If authentication fails, return an error response
        return response()->json([
            'status_code' => Response::HTTP_UNAUTHORIZED,
            'user' => $user,
            'message' => "Oops! It seems your credentials don't match. Please verify and retry."
        ], Response::HTTP_OK);
    }


    public function userProfile()
    {
        $user = Auth::user();

        return view('admin.user.user_profile', compact('user'));


     }


    

    public function updateUserStatus(Request $request, $id)
    {

       // Validate the incoming request data
       $validator = Validator::make($request->all(), [
        'is_active' => 'required|in:0,1',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $message = implode('. ', $errors);

            return  redirect()->back()->with('error', $message); 

        }

        $user = User::find($id);

        // Check if the meeting exists
        if (!$user) {
            return  redirect()->back()->with('error', 'User not found'); 

        }

        // Update the meeting record with the validated data
        $user->update([
            'is_active' => $request->is_active,
        ]
       );
        // Return a success response
        return redirect()->back()->with('message', 'User status updated successfully');

    }

    public function exportExcel()
    {
        return Excel::download(new UserDataExport, 'users-data.xlsx');
    }


    public function printView()
    {
       
        $users = User::all();

        return view('admin.user.print', compact('users'));
    }


    public function exportUserCsv()
    {

        $users = User::all();

        $csvHeader = [
            'Employee ID', 
            'Name', 
            'Role', 
            'Project Code', 
            'Joining Date', 
            'Division', 
            'Designation', 
            'Mobile', 
            'Email', 
            'Address'
        ];
        
        $csvData = $users->map(function ($user) {
            
            return [
                'user_id' => $user->employee_id,
                'name' => $user->name,
                'role' => $user->role->name,
                'project_code' => $user->project_code,
                'joining_date' => $user->start_from,
                'division' => $user->department->name,
                'designaion' => $user->designation,
                'mobile' => $user->mobile_number,
                'email' => $user->email,
                'address' => $user->address,
               
            ];
        });

        
        $filename = 'users-csv-export.csv';
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



    public function exportUserPdf()
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 300);


        $users = User::all();


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
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Project Code</th>
                        <th>Joining Date</th>
                        <th>Division</th>
                        <th>Designaion</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($users as $user) {
            

            $html .= '<tr>';
            $html .= '<td>' . $user->employee_id . '</td>';
            $html .= '<td>' . $user->name .'</td>';
            $html .= '<td>' . $user->role->name . '</td>';
            $html .= '<td>' . $user->project_code . '</td>';
            $html .= '<td>' . $user->start_from . '</td>';
            $html .= '<td>' . $user->department->name . '</td>';
            $html .= '<td>' . $user->designation . '</td>';
            $html .= '<td>' . $user->mobile_number . '</td>';
            $html .= '<td>' . $user->email . '</td>';
            $html .= '<td>' . $user->address . '</td>';
           
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
        return $pdf->download('users-pdf-export.pdf');

    }  

}
