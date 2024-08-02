<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeEducationDetailFormRequest;
use App\Models\EmployeeBasicDetails;
use App\Models\EmployeeEducationDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EducationDetailsController extends Controller
{
    public function index($employee_id) : JsonResponse
    {
        $details = EmployeeEducationDetails::where('employee_id',$employee_id)
        ->orderBy('starting_year', 'DESC')->get();

        return response()->json([
            'message' => 'Record fetch.',
            'data' => [
                'education_details' => $details
            ]
        ] , 200 );
    }

    public function updateEducationDetails(EmployeeEducationDetailFormRequest $request, EmployeeBasicDetails $employeeBasicDetails)
    {
        EmployeeEducationDetails::whereIn('id', $request->deletedRcord())->delete();

        $degree_collection = $request->getRequestFields();
        foreach($degree_collection as $degree)
        {
            $degree_details = $degree['id'] !='' ? EmployeeEducationDetails::findOrFail((int) $degree['id']) : new EmployeeEducationDetails;
            $degree_details->fill($degree)->save();
        }
        $employeeBasicDetails->load('education');

        return response()->json([
            'message' => 'Education details update Successfully.',
            'data' => [
                'employee_education_details' => $employeeBasicDetails->education
            ]
        ] , 200 );
    }
}
