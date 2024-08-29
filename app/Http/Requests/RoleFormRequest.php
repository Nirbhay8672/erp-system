<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RoleFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules() : array 
    {
        return [
            'name' => 'required|string|max:20|unique:roles,display_name,'.$this->id
        ];
    }

    public function getRequestFields() : array
    {
        return [
            'display_name' => $this->name,
            'name' => str::slug($this->name),
        ];
    }
}
