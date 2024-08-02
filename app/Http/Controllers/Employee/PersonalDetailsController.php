<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeePersonalDetailsFormRequest;
use App\Models\EmployeeBasicDetails;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class PersonalDetailsController extends Controller
{
    public function updatePersonalDetails(EmployeePersonalDetailsFormRequest $request, EmployeeBasicDetails $employeeBasicDetails): JsonResponse
    {
        $employeeBasicDetails->fill($request->getRequestFields())->save();
        $employeePersonalDetails = [
            'id' => $employeeBasicDetails['id'],
            'blood_group' => $employeeBasicDetails['blood_group'],
            'marital_status' => $employeeBasicDetails['marital_status'],
            'maritial_status_text' => $employeeBasicDetails->getMaritalStatusDisplayName(),
            'engagement_or_marriage_anniversary' => $employeeBasicDetails->engagement_or_marriage_anniversary,
            'anniversary_date' => $employeeBasicDetails['engagement_or_marriage_anniversary'],
            'hobbies' => $employeeBasicDetails['hobbies'],
            'about' => $employeeBasicDetails['about']
        ];

        if($employeeBasicDetails['engagement_or_marriage_anniversary'] != null){
            $employeePersonalDetails['anniversary_format'] = Carbon::parse($employeeBasicDetails['engagement_or_marriage_anniversary'])->format('d F');
        }
    
        return response()->json([
            'message' => 'Personal details update Successfully.',
            'data' => [
                'employee_personal_details' => $employeePersonalDetails                
            ]
        ] , 200 );
    }
}