<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        User::truncate();

        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        Role::truncate();
        Permission::truncate();

        $permissions_array = [
            // dashboard
            ['display_name' => 'View Dashboard', 'name' => 'view_dashboard', 'category' => 'Dashboard', 'guard_name' => 'web'],

            // profile
            ['display_name' => 'View Profile', 'name' => 'view_profile', 'category' => 'Profile', 'guard_name' => 'web'],
            ['display_name' => 'Update Profile', 'name' => 'update_profile', 'category' => 'Profile', 'guard_name' => 'web'],

            // profile
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

            ['display_name' => 'View Permission', 'name' => 'view_permission', 'category' => 'Permission', 'guard_name' => 'web'],
            ['display_name' => 'Update Permission', 'name' => 'update_permission', 'category' => 'Permission', 'guard_name' => 'web'],
        ];

        DB::table('permissions')->insert($permissions_array);
        $permissionCollection = collect($permissions_array);

        // super admin start
        $super_admin_role = Role::create([
            'name' => 'super_admin',
            'display_name' => 'Super Admin',
        ]);

        $super_admin_role->givePermissionTo($permissionCollection->pluck('name'));

        $super_admin = User::create([
            'name' => 'Nirbhay',
            'first_name' => 'Nirbhay',
            'last_name' => 'Hathaliya', 
            'email' => 'hathaliyank@gmail.com',
            'password' => bcrypt('12345678'),
            'profile_path' => '',
        ]);

        $super_admin->assignRole($super_admin_role);
        $this->storeProfileImage($super_admin);

        // super admin end
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
