<?php

namespace App\Http\Controllers\Employee;

use App\Http\Requests\EmployeeFormRequest;
use App\Http\Requests\EmployeeProfileFormRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('employee/Index',[
            'roles' => Role::all(),
            'page_name' => 'Employees',
        ]);
    }

    public function profile(): Response
    {
        $user = User::find(Auth::user()->id);

        $data = $user->only([
            'id',
            'profile_path',
            'name',
            'email',
            'first_name',
            'last_name',
        ]);

        return Inertia::render('employee/profile/Index', [
            'user_details' => $data,
            'page_name' => 'Profile',
        ]);
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            $search = $request->search;
            $perPage = $request->per_page ?? 10;
            $page = $request->page ?? 1;

            $query = User::with(['roles','designation']);

            if ($search) {
                $query->where('first_name', 'like', '%' . $search . '%');
                $query->orWhere('last_name', 'like', '%' . $search . '%');
                $query->where('email', 'like', '%' . $search . '%');
            }

            $total = $query->count(); 
            $offset = ($page - 1) * $perPage;

            $users = $query->offset($offset)
                ->limit($perPage)
                ->get();

            $total_pages = ceil($total / $perPage);

            $startIndex = ($page - 1) * $perPage;
            $endIndex = min($startIndex + $perPage, $total);

            return $this->successResponse(message: "Users details fetch.", data: [
                'users' => $users,
                'total' => $total,
                'total_pages' => $total_pages,
                'start_index' => $startIndex + 1,
                'end_index' => $endIndex,
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse(message: $exception->getMessage());
        }
    }

    public function updateProfile(EmployeeProfileFormRequest $request, User $employee, UserService $userService): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userService->profileUpdate($request->all());
            
            $employee->refresh();

            $data = $employee->only([
                'id',
                'profile_path',
                'name',
                'email',
                'first_name',
                'last_name',
            ]);

            DB::commit();

            return $this->successResponse(message: "Your Profile has been updated.", data: [
                'user_details' => $data,
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse(message: $exception->getMessage());
        }
    }

    public function createOrUpdate(EmployeeFormRequest $request, User $employee, UserService $userService): JsonResponse
    {
        try {
            DB::beginTransaction();

            $fields = $request->fields();
            $fields['profile_path'] = $employee->exists ? $employee->profile_path : '';
            $employee->fill($fields)->save();
            $employee->assignRole(Role::find($request->role_id));

            if ($request->profile_image) {
                $userService->storeProfileImage($request->profile_image, $employee);
            }

            DB::commit();

            return $this->successResponse(message: "{$employee->name} has been {$request->action()} successfully.");
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse(message: $exception->getMessage());
        }
    }

    public function delete(User $user): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            Storage::disk('public')->delete("/uploads/users/{$user->id}");

            $user->delete();

            DB::commit();

            return $this->successResponse(message: "{$user->name} user has been deleted successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
