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
use Carbon\Carbon;

use App\Models\User;

class MeetingDataExport implements FromCollection, WithHeadings
{

    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

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


         // Apply date filter based on selected value
         $dateFrom = now();
         switch ($this->filter) {
             case '1':
                 $dateFrom = now()->subDays(15);
                 break;
             case '2':
                 $dateFrom = now()->subDays(30);
                 break;
             case '3':
                 $dateFrom = now()->subDays(90);
                 break;
             case '4':
                 $dateFrom = now()->subDays(180);
                 break;
             default:
                 $dateFrom = null;
         }

         if ($dateFrom) {
            $meetingsQuery->whereDate('start_date', '>=', $dateFrom);
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
                'start_date' => $meeting->start_date,
                'meeting_title' => $meeting->meeting_title,
                'room_name' => $meeting->room ? $meeting->room->name : 'N/A',
                'start_time' => $meeting->start_time,
                'end_time' => $meeting->end_time,
                'host_name' => $meeting->host ? $meeting->host->name : '',
                'co_host_name' => $meeting->coHost ? $meeting->coHost->name : 'N/A',
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
            'Date',
            'Title',
            'Room Name',
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