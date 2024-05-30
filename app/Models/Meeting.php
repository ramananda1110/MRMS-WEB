<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Room;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'meeting_title',
        'start_date',
        'start_time',
        'end_time',
        'host_id',
        'co_host_id',
        'booking_type',
        'booking_status',
        'description'
        // Add more fields as needed
    ];

     // Define the participants relationship
     

     public function participants()
    {
        return $this->hasMany(Participant::class);
       
    }

    
    
    public function updateParticipants()
    {
        return $this->belongsToMany(Employee::class, 'participants', 'meeting_id', 'participant_id');
    }

    
    //  public function updateParticipantsWeb($meetingId)
    //     {
    //         return $this->hasMany(Participant::class)->where('meeting_id', $meetingId);
    //     }



    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function host()
    {
        return $this->belongsTo(Employee::class, 'host_id', 'employee_id');
    }

    public function coHost()
    {
        return $this->belongsTo(Employee::class, 'co_host_id', 'employee_id');
    }
}
