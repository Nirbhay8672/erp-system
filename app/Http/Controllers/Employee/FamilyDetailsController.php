<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeFamilyDetailFormRequest;
use App\Models\EmployeeFamilyDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class FamilyDetailsController extends Controller
{
    public function index($employee_id) : JsonResponse
    {
        $details = EmployeeFamilyDetails::where('employee_id',$employee_id)->first();

        return response()->json([
            'message' => 'Record fetch.',
            'data' => [
                'family_details' => $details
            ]
        ] , 200 );
    }

    public function updateFamilyDetails(EmployeeFamilyDetailFormRequest $request)
    {
        $employee_family_details = EmployeeFamilyDetails::where('employee_id', $request->employee_id)->first();
        
        $data = $request->getRequestFields();
        if( $employee_family_details == null ) {
            $employee_family_details = new EmployeeFamilyDetails;
            $data['employee_id'] = $request->employee_id;
        }
        $employee_family_details->fill($data)->save();

        $family_details = EmployeeFamilyDetails::select([
            '*',
            'father_contact_number',
            'mother_contact_number',
            DB::raw('CONCAT(`father_first_name`," ",`father_last_name`) AS father_name'),
            DB::raw('CONCAT(`mother_first_name`," ",`mother_last_name`) AS mother_name'),
        ])
        ->where('employee_id',$request->employee_id)
        ->first();  

        return response()->json([
            'message' => 'Family details update Successfully.',
            'data' => [
                'emploayee_family_details' => $family_details
            ]
        ] , 200 );
    }
}