<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequestFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'leave_type' => 'required',
            'leave_from' => 'required|after_or_equal:today',
            'leave_to' => 'required|after_or_equal:leave_from',
            'reason' => 'required',
        ];

        return $rules;
    }
}
