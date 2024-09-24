<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|min:1|max:20|unique:users,name,' . $this->id,
            'first_name' => 'required|string|min:2|max:20',
            'last_name' => 'required|string|min:2|max:20',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'mobile' => 'required|numeric',
            'gender' => 'required|string',
        ];

        if (!empty($this->password)) {
            $rules['password'] = 'required_if:id,null|nullable|min:6';
            $rules['confirm_password'] = 'required_with:password|same:password';
        }

        return $rules;
    }

    public function basic_details(): array
    {
        $fields = [
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'designation_id' => $this->designation_id,
        ];

        if (!empty($this->password)) {
            $fields['password'] = bcrypt($this->password);
        }

        return $fields;
    }

    public function address_details(): array
    {
        $fields = [
            'state' => $this->state,
            'city' => $this->city,
            'pincode' => $this->pincode,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
        ];

        return $fields;
    }

    public function action(): string
    {
        return is_null($this->id) ? 'created' : 'updated';
    }
}
