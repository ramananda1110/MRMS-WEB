<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    use Notifiable;

    protected $table = 'employees';
    // protected $primaryKey = 'employee_id'; 

    protected $fillable = [
        'employee_id',
        'grade',
        'name',
        'status',
        'division',
        'project_name',
        'project_code',
        'division',
        'designation',
        'mobile_number',
        'email',
    ];


    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'participants', 'participant_id', 'meeting_id');
    }

    /**
     * Get the meetings where the employee is a host.
     */
    public function hostedMeetings()
    {
        return $this->hasMany(Meeting::class, 'host_id');
    }
}
