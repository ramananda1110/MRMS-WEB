<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Imports\EmployeeDataImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employee;
use DataTables;
use App\Models\User;
use App\Notifications\CreateNewUserNotification;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\EmployeeDataExport;

class EmployeeController extends Controller
{

   
    public function index() {

        $employees = Employee::query()->where('status', '=', 'Active')->paginate(30);

        //$employees = Employee::latest()->paginate(30);
        
        return view('admin.employee.index', compact('employees'));

    }

  
    public function searchEmployee(Request $request)
    {
        // Initialize the query builder
        $query = Employee::query();

        // Apply search filters if search query is present
        if ($request->ajax() && $request->has('search')) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('employee_id', 'like', '%' . $search . '%')
                    ->orWhere('division', 'like', '%' . $search . '%')
                    ->orWhere('mobile_number', 'like', '%' . $search . '%')
                    ->orWhere('project_code', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('designation', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results
        $employees = $query->paginate(30);

        // Return the appropriate view for AJAX or standard requests
        if ($request->ajax()) {
            return view('admin.employee.employee_table', compact('employees'))->render();
        }

        return view('admin.employee.index', compact('employees'));
    }




    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
 
        // Get the uploaded file
        $file = $request->file('file');
 
        // Process the Excel file
        Excel::import(new EmployeeDataImport, $file);
 
        return redirect()->back()->with('message', 'User data imported successfully!');
    }


    public function employeeList(Request $request) {
        return response()->json([
            'status_code' => 200,
            'data' => Employee::all(),
            'message' => 'Successes'
            
        ], 200);
     }


     public function getEmployee(Request $request) {
        // Check if the search keyword is provided
        $keyword = $request->input('keyword');
        $apiToken = $request->query('api_token');

        $user = User::where('api_token', $apiToken)->first();

        if (!$keyword) {
            // return response()->json([
            //     'status_code' => 422,
            //     'message' => 'Bad Request: Keyword parameter is required for searching.',
            // ], 200);
            // set default keyword department
            $keyword = $user->department->name;
        }


    
        // Build the query
        $query = Employee::query()->where('status', '=', 'Active');

    
        // Retrieve the filtered data
        $filteredEmployees = $query->get();
       

       
        // Transform the meetings data (similar to the previous API endpoint)
        $data = $filteredEmployees->map(function ($employee) {
            return [
                'id' => $employee->employee_id,
                // 'employee_id' => $employee->emplyee_id,
                'name' => ucwords(strtolower($employee->name)),

                'division' => $employee->division,
                'designation' => $employee->designation,
            ];
        });

        return response()->json([
            'status_code' => 200,
            'data' => $data,
            'message' => 'Success',
        ], 200);
    }


    public function create()
    {
        return view('admin.employee.create');
    }


    public function store(Request $request)
    {
         $this->validate($request, [
             'employee_id'=>'required|unique:employees',
             'name'=>'required',
             'division'=>'required',
             'mobile_number'=>'required',
             'email'=>'required',
             'designation'=>'required',
             'project_code'=>'required',
            
         ]);
       
         $data = $request->all();
         $data['status'] = 'active';
    
         Employee::create($data);
         return redirect()->back()->with('message', 'Employee Created Successfully');
    }


    public function destroy($id)
    {

        $employee = Employee::find($id);
        $employee->delete();
        return redirect()->route('employee.index')->with('message', 'Recored  Deleted');

    }

    public function edit($id)
    {
       $employee = Employee::find($id);
       
        return view('admin.employee.edit', compact('employee'));

    }

    public function update(Request $request, $id)
    {
        
        $notice = Employee::find($id);
        $data = $request->all();
        $notice->update($data);
        return redirect()->route("employee.index")->with('message', 'Employee Updated Successfully');

    }


    public function createUser(Request $request, $id)
    {
        $this->validate($request, [
            'password'=>'required|string',
            'department_id'=>'required',
            'role_id'=>'required',
        ]);
    
        $employee = Employee::find($id);
    
        // Check if a user with the same employee ID already exists
        $existingUser = User::where('employee_id', $employee->employee_id)->first();

        // Check if a user with the same email address already exists
        $existingEmail = User::where('email', $employee->email)->first();

        // If the user already exists, return a message indicating that the user exists
        if ($existingUser) {
            return redirect()->back()->with('error', 'User already exists');
        }

        // If the email already exists, return a message indicating that the email exists
        if ($existingEmail) {
            return redirect()->back()->with('error', 'User with the same email address already exists');
        }
    
        // If the user doesn't exist, create a new user
        $data = $request->all();
        $image = 'avatar2.png';
        $data['name'] = $employee->name;
        $data['employee_id'] = $employee->employee_id;
        $data['project_code'] = $employee->project_code;
        $data['email'] = $employee->email;
        $data['mobile_number'] = $employee->mobile_number;
        $data['designation'] = $employee->designation;
        $data['start_from'] = date('Y-m-d');
       
        $data['image'] = $image;
        $data['password'] = bcrypt($request->password);
        $data['department_id'] = $request->department_id;
        $data['role_id'] = $request->role_id;
    

        $user = Employee::where('email', $employee->email)->first();


        if ($user) {
            $user->notify(new CreateNewUserNotification($employee->employee_id, $employee->name, $request->password));
        }
        
            
        User::create($data);



        return redirect()->back()->with('message', 'User Created Successfully');
    }
    

    public function exportPdf()
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 300);
    
        $employees = Employee::select(
            'employee_id', 
            'grade', 
            'name', 
            'division', 
            'project_name', 
            'designation', 
            'mobile_number', 
            'email'
        )->where('status', 'Active')->limit(500)->get();
    
        \Log::info('PDF generation started');
    
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
            <h1>Employees List</h1>
            <table>
                <thead>
                    <tr>
                        <th>Emp_ID</th>
                        <th>Grade</th>
                        <th>Name</th>
                       
                        <th>Division</th>
                        <th>Project Name</th>
                        <th>Designation</th>
                        <th>Email</th>
                        
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($employees as $employee) {
            $html .= '<tr>';
            $html .= '<td>' . $employee->employee_id . '</td>';
            $html .= '<td>' . $employee->grade . '</td>';
            $html .= '<td>' . $employee->name . '</td>';
            // $html .= '<td>' . $employee->status . '</td>';
            $html .= '<td>' . $employee->division . '</td>';
            $html .= '<td>' . $employee->project_name . '</td>';
            $html .= '<td>' . $employee->designation . '</td>';
          
            $html .= '<td>' . $employee->email . '</td>';
            $html .= '</tr>';
        }
    
        $html .= '</tbody></table></body></html>';
    
        \Log::info('PDF HTML content generated');
    
        // Set paper size and margins
        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'landscape')  // or 'landscape'
            //->setOptions(['defaultFont' => 'sans-serif']);

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
    
        \Log::info('PDF generated');
    
        return $pdf->download('employees-pdf-export.pdf');
    }
    


    public function exportCsv()
    {
        $employees = Employee::select(
            'employee_id', 
            'grade', 
            'name', 
            'status', 
            'division', 
            'project_name', 
            'designation', 
            'mobile_number', 
            'email'
        )->where('status', 'Active')->get();

        $csvHeader = ['Emp_ID', 'Grade', 'Name', 'Status', 'Division', 'Project Name', 'Designation', 'Mobile', 'Email'];
        $csvData = [];

        foreach ($employees as $employee) {
            $csvData[] = [
                $employee->employee_id,
                $employee->grade,
                $employee->name,
                $employee->status,
                $employee->division,
                $employee->project_name,
                $employee->designation,
                $employee->mobile_number,
                $employee->email
            ];
        }

        $filename = 'employees-csv-export.csv';
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

    public function exportExcel()
    {
        return Excel::download(new EmployeeDataExport, 'employees-data.xlsx');
    }

    public function printView()
    {
        $employees = Employee::select('employee_id', 'grade', 'name', 'status', 'division', 'project_name', 'designation', 'mobile_number', 'email')
            ->where('status', 'Active')
            ->limit(1000)
            ->get();

        return view('admin.employee.print', compact('employees'));
    }
}
