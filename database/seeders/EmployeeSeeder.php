<?php

namespace Database\Seeders;

use App\Models\AttendanceDetails;
use App\Models\EmployeeAddressDetails;
use App\Models\EmployeeEducationDetails;
use App\Models\EmployeeExperienceDetails;
use App\Models\LeaveBalance;
use App\Models\LeaveBalanceSummary;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        AttendanceDetails::truncate();
        User::truncate();

        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        Role::truncate();
        Permission::truncate();
        LeaveRequest::truncate();
        LeaveBalance::truncate();
        LeaveBalanceSummary::truncate();

        $permissions_array = [
            // dashboard
            ['display_name' => 'View Dashboard', 'name' => 'view_dashboard', 'category' => 'Dashboard', 'guard_name' => 'web'],

            // profile
            ['display_name' => 'View Profile', 'name' => 'view_profile', 'category' => 'Profile', 'guard_name' => 'web'],
            ['display_name' => 'Update Profile', 'name' => 'update_profile', 'category' => 'Profile', 'guard_name' => 'web'],

            // employee
            ['display_name' => 'View Employees', 'name' => 'view_employees', 'category' => 'Employee', 'guard_name' => 'web'],
            ['display_name' => 'Add Employee', 'name' => 'add_employee', 'category' => 'Employee', 'guard_name' => 'web'],
            ['display_name' => 'Update Employee', 'name' => 'update_employee', 'category' => 'Employee', 'guard_name' => 'web'],
            ['display_name' => 'Delete Employee', 'name' => 'delete_employee', 'category' => 'Employee', 'guard_name' => 'web'],

            // designations
            ['display_name' => 'View Designations', 'name' => 'view_designations', 'category' => 'Designation', 'guard_name' => 'web'],
            ['display_name' => 'Add Designation', 'name' => 'add_designation', 'category' => 'Designation', 'guard_name' => 'web'],
            ['display_name' => 'Update Designation', 'name' => 'update_designation', 'category' => 'Designation', 'guard_name' => 'web'],
            ['display_name' => 'Delete Designation', 'name' => 'delete_designation', 'category' => 'Designation', 'guard_name' => 'web'],

            // roles
            ['display_name' => 'View Roles', 'name' => 'view_roles', 'category' => 'Role', 'guard_name' => 'web'],
            ['display_name' => 'Add Role', 'name' => 'add_role', 'category' => 'Role', 'guard_name' => 'web'],
            ['display_name' => 'Update Role', 'name' => 'update_role', 'category' => 'Role', 'guard_name' => 'web'],
            ['display_name' => 'Delete Role', 'name' => 'delete_role', 'category' => 'Role', 'guard_name' => 'web'],

            // permission
            ['display_name' => 'View Permissions', 'name' => 'view_permissions', 'category' => 'Permission', 'guard_name' => 'web'],
            ['display_name' => 'Update Permissions', 'name' => 'update_permissions', 'category' => 'Permission', 'guard_name' => 'web'],

            // employee leave
            ['display_name' => 'View Employee Leave', 'name' => 'view_employee_leaves', 'category' => 'Employee Leave', 'guard_name' => 'web'],

            // Settings
            ['display_name' => 'View Settings', 'name' => 'view_settings', 'category' => 'Setting', 'guard_name' => 'web'],
        ];

        DB::table('permissions')->insert($permissions_array);
        $permissionCollection = collect($permissions_array);

        // super admin start
        $super_admin_role = Role::create([
            'name' => 'super_admin',
            'display_name' => 'Super Admin',
        ]);

        $super_admin_role->givePermissionTo($permissionCollection->pluck('name'));

        $user_role = Role::create([
            'name' => 'user',
            'display_name' => 'User',
        ]);

        $user_role->givePermissionTo($permissionCollection->pluck('name'));

        $super_admin = User::create([
            'name' => 'Nirbhay',
            'first_name' => 'Nirbhay',
            'last_name' => 'Hathaliya', 
            'email' => 'hathaliyank@gmail.com',
            'mobile' => 8200186326,
            'gender' => 'male',
            'password' => bcrypt('12345678'),
            'designation_id' => rand(1,7),
            'dob' => '1998-08-30',
            'doj' => Carbon::today(),
            'profile_path' => '',
        ]);

        $super_admin->assignRole($super_admin_role);
        $this->storeProfileImage($super_admin);

        LeaveBalance::create([
            'employee_id' => $super_admin->id,
            'casual_leave' => 3,
            'earned_leave' => 2,
            'sick_leave' => 4,
            'compensatory_off' => 1,
            'work_from_home' => 3,
        ]);

        EmployeeAddressDetails::create([
            'employee_id' => $super_admin->id,
            'state' => 'Gujarat',
            'city' => 'Ahmedabad',
            'pincode' => 380013,
            'address_line_1' => 'Vijay cross road',
            'address_line_2' => 'Naranpura',
        ]);

        for ($i=1; $i <= 2; $i++) {
            EmployeeEducationDetails::create([
                'employee_id' => $super_admin->id,
                'degree_name' => "Education $i",
                'university_name' => "University $i",
                'starting_year' => 2016,
                'ending_year' => 2019,
                'is_pursuing' => 0
            ]);
        }

        for ($i=1; $i <= 3; $i++) {
            EmployeeExperienceDetails::create([
                'employee_id' => $super_admin->id,
                'job_title' => 'PHP Developer',
                'joining_date' => '2022-10-10',
                'leaving_date' => '2023-05-30',
                'job_description' => 'I am laravel php developer',
            ]);
        }

        $employee_data = [
            [
                'name' => 'Rishi',
                'first_name' => 'Rushil',
                'last_name' => 'Pipaliya',
                'email' => 'rishi@gmail.com',
                'dob' => '1995-08-30',
                'doj' => '2022-10-25',
            ],
            [
                'name' => 'Bharat',
                'first_name' => 'Bharat',
                'last_name' => 'Makwana',
                'email' => 'bharat@gmail.com',
                'dob' => '1998-08-25',
                'doj' => '2023-09-12',
            ],
            [
                'name' => 'Amit',
                'first_name' => 'Amit',
                'last_name' => 'Shah',
                'email' => 'amitshah@gmail.com',
                'dob' => '1975-04-04',
                'doj' => '2020-07-22',
            ],
            [
                'name' => 'Rahul',
                'first_name' => 'Rahul',
                'last_name' => 'Thakor',
                'email' => 'rahult@gmail.com',
                'dob' => '1999-12-12',
                'doj' => '2020-08-13',
            ],
            [
                'name' => 'Pravin',
                'first_name' => 'Pravin',
                'last_name' => 'Kagda',
                'email' => 'pravin@gmail.com',
                'dob' => '1998-01-10',
                'doj' => '2021-04-25',
            ],
            [
                'name' => 'Sagar',
                'first_name' => 'Sagar',
                'last_name' => 'Chuni Lal',
                'email' => 'sagar@gmail.com',
                'dob' => '1994-10-10',
                'doj' => '2015-03-27',
            ],
            [
                'name' => 'Jigar',
                'first_name' => 'Jigar',
                'last_name' => 'Tank',
                'email' => 'tank@gmail.com',
                'dob' => '1994-06-23',
                'doj' => '2018-10-22',
            ],
        ];

        foreach ($employee_data as $employee) {

            $new_user = User::create([
                'name' => $employee['name'],
                'first_name' => $employee['first_name'],
                'last_name' => $employee['last_name'],  
                'email' => $employee['email'],
                'mobile' => 8200186326,
                'gender' => 'male',
                'password' => bcrypt('12345678'),
                'designation_id' => rand(1,7),
                'dob' => $employee['dob'],
                'doj' => $employee['doj'],
                'profile_path' => '',
            ]);
    
            $new_user->assignRole($user_role);
            $this->storeProfileImage($new_user);

            LeaveBalance::create([
                'employee_id' => $new_user->id,
                'casual_leave' => 1,
                'earned_leave' => 2,
                'sick_leave' => 4,
                'compensatory_off' => 2,
                'work_from_home' => 6,
            ]);
    
            EmployeeAddressDetails::create([
                'employee_id' => $new_user->id,
                'state' => 'Gujarat',
                'city' => 'Ahmedabad',
                'pincode' => 380013,
                'address_line_1' => 'Vijay cross road',
                'address_line_2' => 'Naranpura',
            ]);
    
            for ($i=1; $i <= 2; $i++) {
                EmployeeEducationDetails::create([
                    'employee_id' => $new_user->id,
                    'degree_name' => "Education $i",
                    'university_name' => "University $i",
                    'starting_year' => 2016,
                    'ending_year' => 2019,
                    'is_pursuing' => 0
                ]);
            }
    
            for ($i=1; $i <= 3; $i++) {
                EmployeeExperienceDetails::create([
                    'employee_id' => $new_user->id,
                    'job_title' => 'PHP Developer',
                    'joining_date' => '2022-10-10',
                    'leaving_date' => '2023-05-30',
                    'job_description' => 'I am laravel php developer',
                ]);
            }
        }
    }

    public function storeProfileImage($admin)
    {
        $sourceFilePath = public_path('/images/profile.png');
        $destinationPath = public_path('/uploads/employees/' . $admin->id);
        $fileName = time() . '.jpg';

        if (File::exists($destinationPath . '/' . $fileName)) {
            return 'File already exists!';
        }

        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        File::copy($sourceFilePath, $destinationPath . '/' . $fileName);

        $admin->fill([
            'profile_path' => '/uploads/employees/' . $admin->id . '/' . $fileName,
        ])->save();
    }
}
