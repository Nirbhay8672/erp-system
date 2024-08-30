<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('role/Index',[
            'page_name' => 'Roles',
        ]);
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            $search = $request->search;
            $perPage = $request->per_page ?? 10;
            $page = $request->page ?? 1;

            $query = Role::query();

            if ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            }

            $total = $query->count(); 
            $offset = ($page - 1) * $perPage;

            $designations = $query->offset($offset)
                ->limit($perPage)
                ->get();

            $total_pages = ceil($total / $perPage);

            $startIndex = ($page - 1) * $perPage;
            $endIndex = min($startIndex + $perPage, $total);

            return $this->successResponse(message: "roles details fetch.", data: [
                'roles' => $designations,
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

    public function storeOrUpdate(RoleFormRequest $request, Role $role) : JsonResponse
    {
        $role->fill($request->getRequestFields())->save();

        $message = '';

        if($request->id > 0 ) {
            $message = $role->display_name . ' Role update successfully.';
        } else {
            $message = $role->display_name . ' Role created successfully.';
        }

        return response()->json([
            'message' => $message,
        ] , 200 );
    }
    
    public function destroy(Role $role) : JsonResponse
    {
        $exist = DB::table('model_has_roles')->where('role_id',$role->id)->get();
        
        if(count($exist) > 0 ) {
            return response()->json([
                'message' => $role->display_name . " role in used.",
            ] , 500 );
        }

        $role->delete();

        return response()->json([
            'message' => $role->display_name . " role delete successfully.",
        ] , 200 );
    }
}
