<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NotificationReceiver;

class Notification extends Model
{
    use HasFactory;

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
}
