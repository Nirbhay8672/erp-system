<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
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
            ['display_name' => 'View Users', 'name' => 'view_users', 'category' => 'User', 'guard_name' => 'web'],
            ['display_name' => 'Update User', 'name' => 'update_user', 'category' => 'User', 'guard_name' => 'web'],
            ['display_name' => 'Delete User', 'name' => 'delete_user', 'category' => 'User', 'guard_name' => 'web'],
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
            'name' => 'Nux',
            'first_name' => 'Nux',
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
        $destinationPath = public_path('/uploads/users/' . $admin->id);
        $fileName = time() . '.jpg';

        if (File::exists($destinationPath . '/' . $fileName)) {
            return 'File already exists!';
        }

        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        File::copy($sourceFilePath, $destinationPath . '/' . $fileName);

        $admin->fill([
            'profile_path' => '/uploads/users/' . $admin->id . '/' . $fileName,
        ])->save();
    }
}
