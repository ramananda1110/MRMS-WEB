<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;


class EmployeeImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue 
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            Employee::updateOrCreate(
                [
                    'employee_id' => $row['employee_id'],
                ],
                [
                // 'employee_id' => $row['employee_id'],
                'name' => $row['name'],
                'project' => $row['project'],
                'division' => $row['division'],
                'designation' => $row['designation'],
                'password' => '1234',
                ]
            );
        }
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
