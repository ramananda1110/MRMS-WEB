<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Imports\ExcelImpoter;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employee;
use DataTables;



class EmployeeController extends Controller
{

    public function index() {

        // $employees = Employee::latest()->get();
        $employees = Employee::latest()->paginate(30);
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
        if (!$keyword) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Bad Request: Keyword parameter is required for searching.',
            ], 400);
        }
    
        // Build the query
        $query = Employee::query();
    
        // Apply search filter across multiple columns
        $query->where(function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('project', 'like', '%' . $keyword . '%')
                  ->orWhere('designation', 'like', '%' . $keyword . '%')
                  ->orWhere('division', 'like', '%' . $keyword . '%');
        });
    
        // Retrieve the filtered data
        $filteredEmployees = $query->get();
    
        return response()->json([
            'status_code' => 200,
            'data' => $filteredEmployees,
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
             'employee_id'=>'required',
             'name'=>'required',
             'division'=>'required',
             'mobile_number'=>'required',
             'email'=>'required',
             'designation'=>'required',
             'project_code'=>'required',
            
         ]);
       
         $data = $request->all();
         Employee::create($data);
         return redirect()->back()->with('message', 'Employee Created Successfully');
    }
}
