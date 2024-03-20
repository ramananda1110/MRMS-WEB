<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Employee;

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
        'status',
        // Add more fields as needed
    ];

     // Define the participants relationship
     

     public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
