<?php

namespace App\Http\Controllers\ProjectMaster;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectMasterFormRequest;
use App\Models\ProjectMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectMasterController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('projectMaster/Index' , [
            'page_name' => 'Project Master',
        ]);
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            $search = $request->search;
            $perPage = $request->per_page ?? 10;
            $page = $request->page ?? 1;

            $query = ProjectMaster::query();

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

            return $this->successResponse(message: "projects details fetch.", data: [
                'projects' => $designations,
                'total' => $total,
                'total_pages' => $total_pages,
                'start_index' => $startIndex + 1,
                'end_index' => $endIndex,
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse(message: $exception->getMessage());
        }
    }

    public function storeOrUpdate(ProjectMasterFormRequest $request, ProjectMaster $project) : JsonResponse
    {
        $project->fill($request->getRequestFields())->save();

        $message = '';

        if($request->id > 0 ) {
            $message = $project->name . ' Project update successfully.';
        } else {
            $message = $project->name . ' Project created successfully.';
        }

        return response()->json([
            'message' => $message,
        ] , 200 );
    }

    public function destroy(ProjectMaster $project) : JsonResponse
    {
        $project->delete();

        return response()->json([
            'message' => $project->name . " project delete successfully.",
        ] , 200 );
    }
}
