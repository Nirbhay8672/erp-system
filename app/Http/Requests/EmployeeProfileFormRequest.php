<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeProfileFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|unique:users,name,' . $this->id,
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'nullable|email|unique:users,email,' . $this->id,
            'profile_image' => 'file|mimes:jpeg,png|max:2000',
        ];

        if ($this->password != '' || $this->confirm_password != '') {
            $rules['password'] = 'required|min:6';
            $rules['confirm_password'] = 'required_with:password|same:password';
        }

        return $rules; 
    }
}
