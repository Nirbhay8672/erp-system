<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeBankDetailFormRequest;
use App\Models\EmployeeBankDetails;
use App\Models\EmployeeBasicDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class BankDetailsController extends Controller
{
    public function index($employee_id) : JsonResponse
    {
        $details = EmployeeBankDetails::where('employee_id',$employee_id)->first();

        return response()->json([
            'message' => 'Record fetch.',
            'data' => [
                'bank_details' => $details
            ]
        ] , 200 );
    }

    public function updateBankDetails(EmployeeBankDetailFormRequest $request)
    {
        $employee_bank_details = EmployeeBankDetails::where('employee_id', $request->employee_id)->first();
        $data = $request->getRequestFields();

        if( $employee_bank_details == null ) {
            $employee_bank_details = new EmployeeBankDetails;
            $data['employee_id'] = $request->employee_id;
        }
        $employee_bank_details->fill($data)->save();
        $employee_bank_details['mask_account_number'] = Str::mask($employee_bank_details->account_number, '*', 2, 5);

        return response()->json([
            'message' => 'Bank details update Successfully.',
            'data' => [
                'bank_details' => $employee_bank_details
            ]
        ] , 200 );
    }
}