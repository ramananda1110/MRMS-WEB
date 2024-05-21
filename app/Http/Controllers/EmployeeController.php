<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Imports\ExcelImpoter;
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

        // $employees = Employee::latest()->get();
       
        $employees = Employee::query()->where('status', '=', 'Active')->paginate(30);

        //$employees = Employee::latest()->paginate(30);
        return view('admin.employee.index', compact('employees'));

    }

    public function searchEmployee(Request $request){
       
        if($request->search){
            $employees = Employee::where('name','like','%'.$request->search.'%')
            ->orWhere('employee_id','like','%'.$request->search.'%')
            ->orWhere('division','like','%'.$request->search.'%')
            ->orWhere('mobile_number','like','%'.$request->search.'%')
            ->orWhere('project_code','like','%'.$request->search.'%')
            ->orWhere('email','like','%'.$request->search.'%')
            ->orWhere('designation','like','%'.$request->search.'%')
            ->paginate(30);
            return view('admin.employee.index',compact('employees'));
        }


        $employees  =Employee::latest()->paginate(30);
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
        Excel::import(new ExcelImpoter, $file);
 
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

    
        // Apply search filter across multiple columns
        // temporary off filter data 
        // $query->where(function ($query) use ($keyword) {
        //     $query->where('name', 'like', '%' . $keyword . '%')
        //           ->orWhere('project_name', 'like', '%' . $keyword . '%')
        //           ->orWhere('designation', 'like', '%' . $keyword . '%')
        //           ->orWhere('division', 'like', '%' . $keyword . '%');
        // });
    
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
        $department = Employee::find($id);
        $department->delete();
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
        $employees = Employee::select('employee_id', 'name', 'division')->get();

        $html = '<h1>Employees List</h1>';
        $html .= '<table border="1" cellspacing="0" cellpadding="5">';
        $html .= '<thead><tr><th>ID</th><th>Name</th><th>Division</th></tr></thead><tbody>';

        foreach ($employees as $employee) {
            $html .= '<tr>';
            $html .= '<td>' . $employee->employee_id . '</td>';
            $html .= '<td>' . $employee->name . '</td>';
            $html .= '<td>' . $employee->division . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        $pdf = Pdf::loadHTML($html);

        return $pdf->download('employees.pdf'); // to download the PDF
        // return $pdf->stream('employees.pdf'); // to preview the PDF in the browser
    }
   

    public function exportExcel()
    {
        return Excel::download(new EmployeeDataExport, 'employees-data.xlsx');
    }
}
