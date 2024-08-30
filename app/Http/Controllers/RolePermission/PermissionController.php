<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('permission/Index');
    }

    public function details(): JsonResponse
    {
        $roles = Role::all();
        $permissions = Permission::orderBy('category')->get();

        foreach ($roles as $role) {
            $permissions_array = [];
            foreach ($permissions as $permission) {
                array_push($permissions_array, [
                    'name' => $permission->name,
                    'id' => $permission->id,
                    'has_permission' => $role->hasPermissionTo($permission->name) ? true : false,
                ]);
            }
            $role->role_permission = $permissions_array;
        }

        return response()->json([
            'roles' => $roles,
            'all_permissions' => $permissions->groupBy('category'),
        ]);
    }

    public function assignPermission(Request $request): JsonResponse
    {
        foreach ($request->role_id as $roleId) {
            $roleObj = Role::find($roleId);
            $roleObj->syncPermissions($request->permission[$roleId] ?? []);
        }

        return response()->json(['message' => 'Permissions has been updated.']);
    }
}
