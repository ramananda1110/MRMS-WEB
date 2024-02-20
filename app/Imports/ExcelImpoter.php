<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Employee;

class ExcelImpoter implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
       {
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
    }
}
