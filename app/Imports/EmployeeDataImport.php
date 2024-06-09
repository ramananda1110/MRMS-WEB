<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Employee;

class EmployeeDataImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
            {
                try {
                    $existingEmployee = Employee::where('employee_id', $row['employee_id'])->first();

                    if (!$existingEmployee) {
                        Employee::create([
                            'employee_id' => $row['employee_id'],
                            'grade' => $row['job_grade'],
                            'name' => $row['employee_name'],
                            'status' => $row['status'],
                            'division' => $row['division'],
                            'project_name' => $row['project_name'],
                            'project_code' => $row['project_code'],
                            'designation' => $row['designation'],
                            'mobile_number' => $row['mobile_number'],
                            'email' => $row['email'],
                        ]);
                    }
                } catch (\Exception $e) {
                    // Log the error message for debugging
                    Log::error('Error importing row: ' . $e->getMessage());
                    // Optionally, you can add code to handle the error (e.g., notify the user)
                }
            }
    }
}
