<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\User;
use App\Models\Role;
use App\Models\Room;
use App\Models\Permission;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

     protected $departments = [
        'ABAD', 'ADMD', 'BPD', 'DSD', 'EPD', 'HO', 'ICTD', 'PRD', 'RBD', 'RDD', 'WRED'
    ];

    protected $roles = [
        'admin', 'manager', 'employee', 'supervisor', 'Team lead', 'executive', 'sales rep', 'customer service', 'HR', 'IT Specialist'
    ];


    public function run()
    {
        // \App\Models\User::factory(10)->create();

        foreach ($this->departments as $department) {
            Department::create([
                'name' => $department,
                'description' => 'This short description for ' . $department . '.'
            ]);
        }

        foreach ($this->roles as $role) {
            Role::create([
                'name' => $role,
                'description' => 'This role is ' . $role . '.'
            ]);
        }
    

        Room::create([
            'name'=>'RBD',
            'location'=>'2nd floor',
            'capacity'=> 10,
            'facilities'=>'Built-in TV spekar',
        ]);

        Room::create([
            'name'=>'BPD',
            'location'=>'4th floor',
            'capacity'=> 14,
            'facilities'=>'Built-in projector spekar',
        ]);

        Room::create([
            'name'=>'ADMD',
            'location'=>'9th floor',
            'capacity'=> 25,
            'facilities'=>'Built-in projector speaker, Projector/TV',
        ]);

        Room::create([
            'name'=>'DSD',
            'location'=>'10th floor',
            'capacity'=> 17,
            'facilities'=>'portable projector',
        ]);


        User::create([
            'employee_id'=>'10001',
            'project_code'=>'PROJ000077',
            'name'=>'DDCL Private Ltd.',
            'email'=>'admin@ddclbd.com',
            'password'=>bcrypt('password'),
            'email_verified_at'=>NOW(),
            'address'=>'Bangladesh',
            'mobile_number'=>'01738039685',
            'department_id'=>6,
            'role_id'=>1,
            'start_from'=> '1952-02-02',
            'designation'=> 'Director',
            'image' => ''
        ]);

        User::create([
            'employee_id'=>'14080',
            'project_code'=>'PROJ000254',
            'name'=>'Ramananda Sarkar',
            'email'=>'ramananda.ddcl@gmail.com',
            'password'=>bcrypt('password2'),
            'email_verified_at'=>NOW(),
            'address'=>'Bangladesh',
            'mobile_number'=>'01738039685',
            'department_id'=>7,
            'role_id'=>1,
            'start_from'=> '2023-12-11',
            'designation'=> 'Software Engineer',
            'image' => ''
        ]);

        User::create([
            'employee_id'=>'14071',
            'project_code'=>'PROJ000254',
            'name'=>'TAHMID MAHTAB RATUL',
            'email'=>'tahmid.ddclbd@gmail.com',
            'password'=>bcrypt('password3'),
            'email_verified_at'=>NOW(),
            'address'=>'Mirpur, Dahka Bangladesh',
            'mobile_number'=>'01628853526',
            'department_id'=>7,
            'role_id'=>3,
            'start_from'=> '2023-12-03',
            'designation'=> 'UI/UX EXPERT',
            'image' => ''
        ]);


        // create a default permission

        // JSON string with your data
        $jsonData = '{"meeting":{"can-add":"1","can-edit":"1","can-view":"1","can-delete":"1","can-list":"1"},"employee":{"can-add":"1","can-edit":"1","can-view":"1","can-delete":"1","can-list":"1"},"department":{"can-add":"1","can-edit":"1","can-view":"1","can-delete":"1","can-list":"1"},"role":{"can-add":"1","can-edit":"1","can-view":"1","can-delete":"1","can-list":"1"},"permission":{"can-add":"1","can-edit":"1","can-view":"1","can-delete":"1","can-list":"1"},"user":{"can-add":"1","can-edit":"1","can-view":"1","can-delete":"1","can-list":"1"},"room":{"can-add":"1","can-edit":"1","can-view":"1","can-delete":"1","can-list":"1"},"leave":{"can-list":"1"},"notice":{"can-add":"1","can-edit":"1","can-view":"1","can-delete":"1","can-list":"1"},"leave":{"can-list":"1"}}';

        // Decode the JSON string into a PHP associative array
        $data = json_decode($jsonData, true);

        Permission::create([
            'role_id'=>1,
            'name'=> $data
        ]);
    }


}
