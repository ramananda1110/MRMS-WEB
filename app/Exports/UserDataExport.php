<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UserDataExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
       
        $users = User::all();

        $data = $users->map(function ($user) {
            
            return [
                'user_id' => $user->employee_id,
                'name' => $user->name,
                'role' => $user->role->name,
                'project_code' => $user->project_code,
                'joining_date' => $user->start_from,
                'division' => $user->department->name,
                'designaion' => $user->designation,
                'mobile' => $user->mobile_number,
                'email' => $user->email,
                'address' => $user->address,
               
            ];
        });

        return $data;

    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'User ID',
            'Name',
            'Role',
            'Project Code',
            'Joining Date',
            'Division',
            'Designation',
            'Mobile Number',
            'Email',
            'Address'
            // Add other headers as needed
        ];
    }
}