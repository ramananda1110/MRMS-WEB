<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Meeting;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class MeetingDataExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
         // Retrieve the authenticated user's employee ID and role ID
         $employeeId = Auth()->user()->employee_id;
         $roleId = Auth()->user()->role_id;
 
        
        $meetingsQuery = Meeting::with(['room', 'host', 'coHost', 'participants.employee']);


        if ($roleId !== 1) {
            $meetingsQuery->where(function ($query) use ($employeeId) {
                $query->where('host_id', $employeeId)
                    ->orWhereHas('participants', function ($query) use ($employeeId) {
                        $query->where('participant_id', $employeeId);
                    });
            });
        }

        $meetings = $meetingsQuery->get();


        $data = $meetings->map(function ($meeting) {
            // Concatenate participants' details into a single string
            $participants = $meeting->participants->map(function ($participant) {
                return $participant->employee ? 
                    "{$participant->employee->name} (Division: {$participant->employee->division}, Designation: {$participant->employee->designation})" 
                    : '';
            })->implode(', ');

            // Determine the status based on conditions
            $status = $meeting->booking_status;

            return [
                'id' => $meeting->id,
                'room_name' => $meeting->room ? $meeting->room->name : 'N/A',
                'meeting_title' => $meeting->meeting_title,
                'start_date' => $meeting->start_date,
                'start_time' => $meeting->start_time,
                'end_time' => $meeting->end_time,
                'host_name' => $meeting->host ? $meeting->host->name : '',
                'co_host_name' => $meeting->coHost ? $meeting->coHost->name : 'New',
                'booking_type' => $meeting->booking_type,
                'booking_status' => $status,
                'description' => $meeting->description,
                'participants' => $participants,
            ];
        });

        // Order meetings by latest start_date
        $data = $data->sortByDesc('start_date')->values();

        return  $data;

    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id',
            'Room Name',
            'Title',
            'Date',
            'Start Time',
            'End Time',
            'Host',
            'Co-Host',
            'Type',
            'Status',
            'Description',
            'Participants'
            // Add other headers as needed
        ];
    }
}