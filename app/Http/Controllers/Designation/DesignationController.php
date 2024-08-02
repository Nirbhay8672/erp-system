<?php

namespace App\Http\Controllers\Designation;

use App\Http\Controllers\Controller;
use App\Http\Requests\DesignationFormRequest;
use App\Models\DesignationDetails;
use App\Models\EmployeeBasicDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DesignationController extends Controller
{
    public function index()
    {
        return Inertia::render('designation/Index',[
            'user' => Auth::user(),
            'url' => url('/')
        ]);
    }

    public function fetchRecord(): JsonResponse
    {
        return response()->json(DesignationDetails::all());
    }

    public function storeOrUpdate(DesignationFormRequest $request, DesignationDetails $designation) : JsonResponse
    {
        $designation->fill($request->getRequestFields())->save();

        return response()->json([
            'message' => 'Record add or update Successfully.'
        ] , 200 );
    }
    
    public function destroy(DesignationDetails $designation) : JsonResponse
    {                        
        $employee = EmployeeBasicDetails::where('designation_id',$designation->id)->first();
        
        if($employee) { 
            return response()->json([
                'message' => 'You can not delete this designation.'
            ] , 500 );
        }

        $designation->delete();

        return response()->json([
            'message' => 'Record delete successfully.'
        ] , 200 );
    }
}
