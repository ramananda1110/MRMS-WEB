<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notifications;
use App\Models\Participant;

class NotificationReceiver extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_id',
        'participant_id',
        'is_read'
    ];

    // Each receiver belongs to a notification
    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    // A receiver is also related to a participant
    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
}
