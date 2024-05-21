<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Meeting;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;


class EmployeeDataExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Employee::all();

        return Employee::select('employee_id', 'grade', 'name', 'status', 'division', 'project_name', 'designation', 'mobile_number', 'email')
        ->where('status', 'Active')
        ->get();

    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Employee ID',
            'Grade',
            'Name',
            'Status',
            'Division',
            'Project Name',
            'Designation',
            'Mobile Number',
            'Email'
            // Add other headers as needed
        ];
    }
}