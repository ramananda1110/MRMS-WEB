<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = [
        'employee_id',
        'name',
        'project',
        'division',
        'designation',
        'password',
    ];

}
