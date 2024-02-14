<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Imports\ExcelImpoter;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employee;



class ExcelImportController extends Controller
{

    public function index() {

        // $employees = Employee::latest()->get();
        $employees = Employee::latest()->paginate(30);


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

}
