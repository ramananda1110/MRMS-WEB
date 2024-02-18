<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Imports\ExcelImpoter;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employee;
use DataTables;



class ExcelImportController extends Controller
{

    public function index() {

        // $employees = Employee::latest()->get();
        $employees = Employee::latest()->paginate(30);
        return view('admin.employee.index', compact('employees'));

    }

        //     public function index(Request $request)
        //     {
        //     $query = Employee::latest();

        //     // Apply filters based on request parameters
        //     if ($request->has('division')) {
        //         $query->where('division', $request->division);
        //     }
        //     if ($request->has('designation')) {
        //         $query->where('designation', $request->designation);
        //     }

        //     // Perform server-side processing with DataTables and pagination
        //     $employees = DataTables::of($query)
        //         ->addColumn('action', function ($employee) {
        //             $actionButtons = '';
        //             // Edit button (conditional based on user role)
        //             if (auth()->user()->can('edit employees')) {
        //                 $actionButtons .= '<a href="' . route('employees.edit', $employee->id) . '" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>';
        //             }
        //             // Delete button (conditional based on user role)
        //             if (auth()->user()->can('delete employees')) {
        //                 $actionButtons .= '<button class="btn btn-danger btn-sm delete-employee" data-employee-id="' . $employee->id . '" title="Delete"><i class="fas fa-trash"></i></button>';
        //             }
        //             return $actionButtons;
        //         })
        //         ->addIndexColumn() // Add an index column for server-side processing
        //         ->paginate(10) // Set the initial pagination limit to 10
        //         ->make(true);

        //     return view('admin.employee.index', compact('employees'));
        // }
    
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
        //return Room::all();

        return response()->json([
            'status_code' => 200,
            'data' => Employee::all(),
            'message' => 'Successes'
            
        ], 200);
     }


}
