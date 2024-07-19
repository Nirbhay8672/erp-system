<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserProfileFormRequest;
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

class UserController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('user/Index',[
            'roles' => Role::all(),
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

        return Inertia::render('user/profile/Index', [
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

            $query = User::with(['roles']);

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

    public function updateProfile(UserProfileFormRequest $request, User $user, UserService $userService): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userService->profileUpdate($request->all());
            $user->refresh();

            $data = $user->only([
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

    public function createOrUpdate(UserFormRequest $request, User $user, UserService $userService): JsonResponse
    {
        try {
            DB::beginTransaction();

            $fields = $request->fields();
            $fields['profile_path'] = $user->exists ? $user->profile_path : '';
            $user->fill($fields)->save();
            $user->assignRole(Role::find($request->role_id));

            if ($request->profile_image) {
                $userService->storeProfileImage($request->profile_image, $user);
            }

            DB::commit();

            return $this->successResponse(message: "{$user->name} has been {$request->action()} successfully.");
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
