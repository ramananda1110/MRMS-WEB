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
                'division' => $row['division'],
                'project' => $row['project'],
                'name' => $row['name'],
                'designation' => $row['designation'],
                // 'password' => bcrypt('1234'),
                'password' => '1234',
            ]);
       }
    }
}
