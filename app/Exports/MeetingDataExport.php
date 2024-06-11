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

    protected $meetings;


    public function __construct($meetings)
    {
        $this->meetings = $meetings;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $data = $this->meetings->map(function ($meeting) {
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