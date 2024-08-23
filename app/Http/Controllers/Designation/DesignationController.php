<?php

namespace App\Http\Controllers\Designation;

use App\Http\Controllers\Controller;
use App\Http\Requests\DesignationFormRequest;
use App\Models\DesignationDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\Inertia;

class DesignationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('designation/Index',[
            'page_name' => 'Designations',
        ]);
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            $search = $request->search;
            $perPage = $request->per_page ?? 10;
            $page = $request->page ?? 1;

            $query = DesignationDetails::query();

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

            return $this->successResponse(message: "designation details fetch.", data: [
                'designations' => $designations,
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

    public function storeOrUpdate(DesignationFormRequest $request, DesignationDetails $designation) : JsonResponse
    {
        $designation->fill($request->getRequestFields())->save();

        $message = '';

        if($request->id > 0 ) {
            $message = $designation->name . ' Designation update successfully.';
        } else {
            $message = $designation->name . ' Designation created successfully.';
        }

        return response()->json([
            'message' => $message,
        ] , 200 );
    }
    
    public function destroy(DesignationDetails $designation) : JsonResponse
    {
        $designation->delete();

        return response()->json([
            'message' => 'Record delete successfully.'
        ] , 200 );
    }
}
