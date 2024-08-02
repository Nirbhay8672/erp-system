<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeExperienceDetailFormRequest;
use App\Models\EmployeeBasicDetails;
use App\Models\EmployeeExperienceDetails;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ExperienceDetailsController extends Controller
{
    public function index($employee_id) : JsonResponse
    {
        $details = EmployeeExperienceDetails::select([
            'employee_experience_details.*',
            DB::raw("DATE_FORMAT(joining_date, '%d/%m/%Y') AS joining_date_format"),
            DB::raw("DATE_FORMAT(leaving_date, '%d/%m/%Y') AS leaving_date_format")
        ])
        ->where('employee_id',$employee_id)
        ->orderBy('joining_date', 'DESC')
        ->get();

        return response()->json([
            'message' => 'Record fetch.',
            'data' => [
                'experience_details' => $details
            ]
        ] , 200 );
    }

    public function updateExperienceDetails(EmployeeExperienceDetailFormRequest $request,  EmployeeBasicDetails $employeeBasicDetails)
    {
        $experience_collection = $request->getRequestFields();

        EmployeeExperienceDetails::whereIn('id', $request->deletedRcord())->delete();

        foreach($experience_collection as $experience)
        {
            if($experience['id'] !='')
            {
                $experience_details = EmployeeExperienceDetails::findOrFail((int) $experience['id']);
            }
            else
            {
                $experience_details = new EmployeeExperienceDetails;
            }
            $experience_details->fill($experience)->save();
        }

        $employeeBasicDetails->load('experience');

        $employeeExperienceDetails = [];
        foreach($employeeBasicDetails->experience as $experience) {
            array_push($employeeExperienceDetails,[
                'id' => $experience->id,
                'job_title' => $experience->job_title,
                'company_name' => $experience->company_name,
                'department' => $experience->department,
                'description' => $experience->description,
                'joining_date' => date($experience->joining_date),
                'leaving_date' => $experience->leaving_date,
                'joining_date_format' => Carbon::createFromFormat('Y-m-d H:i:s', $experience->joining_date)->format('d/m/Y'),
                'is_still_continue' => $experience->is_still_continue,
                'leaving_date_format' => $experience->leaving_date ? Carbon::createFromFormat('Y-m-d H:i:s', $experience->leaving_date)->format('d/m/Y') : null
            ]);
        }
        
        return response()->json([
            'message' => 'Experience details update Successfully.',
            'data' => [
                'employee_experience_details' => $employeeExperienceDetails
            ]
        ] , 200 );
    }
}