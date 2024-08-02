<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeBasicDetailsFormRequest;
use App\Models\EmployeeBasicDetails;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BasicDetailsController extends Controller
{
    public function index($id) : JsonResponse
    {
        $details = EmployeeBasicDetails::select([
            'employee_basic_details.*',
            DB::raw("DATE_FORMAT(date_of_birth, '%d/%m/%Y') AS date_of_birth_format"),
            DB::raw("DATE_FORMAT(engagement_or_marriage_anniversary, '%d/%m/%Y') AS anniversary_format")
        ])->with('user')->findOrFail($id);

        return response()->json([
            'message' => 'Record fetch.',
            'data' => [
                'basic_details' => $details
            ]
        ] , 200 );
    }

    public function updateBasicDetails(EmployeeBasicDetailsFormRequest $request, EmployeeBasicDetails $employeeBasicDetails): JsonResponse
    {
        $employeeBasicDetails->fill($request->getRequestFields())->save();
        $user = User::where('employee_id',(int) $employeeBasicDetails->id)->firstOrFail();
        $user->fill([
            'user_name' => $request->user_name,
            'email_address' => $request->email
        ])->save();

        $employeeBasicDetails->load('user');
        $employeeBasicDetails->user->load('roles');
        $employeeBasicDetails->role_name = $employeeBasicDetails->user->roles[0]->name;
        $employeeBasicDetails->user_id = $employeeBasicDetails->user->id;
        $employeeBasicDetails->username = $employeeBasicDetails->user->user_name;
        $employeeBasicDetails->email_address = $employeeBasicDetails->user->email_address;
        $employeeBasicDetails->employee_name = $employeeBasicDetails['first_name'].' '.$employeeBasicDetails['last_name'];
        $employeeBasicDetails->gender_text = $employeeBasicDetails->getGenderDisplayName();
        $employeeBasicDetails->joining_date_format = Carbon::parse($employeeBasicDetails['joining_date'])->format('d F Y');
        $employeeBasicDetails->date_of_birth_formated_text = Carbon::parse($employeeBasicDetails['date_of_birth'])->format('d F');

        return response()->json([
            'message' => 'Basic details update Successfully.',
            'data' => [
                'employee_basic_details' => $employeeBasicDetails
            ]
        ] , 200 );
    }
}