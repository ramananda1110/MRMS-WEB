<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NotificationReceiver;
use Carbon\Carbon;

class Notifications extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'type',
        'title',
        'body',
        'meeting_id'
    ];

    // A notification has many receivers
    public function receivers()
    {
        return $this->hasMany(NotificationReceiver::class);
    }


    // Accessor to format the created_at attribute
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
