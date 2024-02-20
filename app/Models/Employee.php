<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
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
}
