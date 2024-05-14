<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Department;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'project_code',
        'name',
        'email',
        'is_active',
        'password',
        'address',
        'mobile_number',
        'department_id',
        'designation',
        'role_id',
        'image',
        'api_token',
        'start_from',
        'device_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function department(){
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function isAdmin(){
        return $this->hasOne(Role::class, 'id', 'role_id')->select('name')
            ->withDefault(['name' => ''])
            ->get()
            ->map(function ($role) {
                return strtolower($role->name) === 'admin';
            })
            ->first();
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'host_id', 'id');
    }
}
