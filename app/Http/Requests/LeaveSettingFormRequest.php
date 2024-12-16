<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveSettingFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules =  [
            'casual_leave.details.add_leave_per_month' => 'required|numeric',
            'casual_leave.details.max_leave_per_month' => 'required|numeric',
            'casual_leave.details.total_leave_per_year' => 'required|numeric',

            'earned_leave.details.add_leave_per_month' => 'required|numeric',
            'earned_leave.details.max_accumulated_leaves' => 'required|numeric',
            'earned_leave.details.total_leave_per_year' => 'required|numeric',

            'sick_leave.details.add_leave_per_month' => 'required|numeric',
            'sick_leave.details.total_leave_per_year' => 'required|numeric',

            'work_from_home.details.add_leave_per_month' => 'required|numeric',
            'work_from_home.details.total_leave_per_year' => 'required|numeric',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'The field is required.',
            'numeric' => 'The field must be numeric.',
            'boolean' => 'The field must be boolean.',
        ];
    }
}
