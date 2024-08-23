<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesignationFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules() : array 
    {
        return [
            'name' => 'required|string|max:20|unique:designation_details,name,'.$this->id
        ];
    }

    public function getRequestFields() : array
    {
        return [
            'name' => $this->name
        ];
    }
}
