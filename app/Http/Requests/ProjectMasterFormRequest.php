<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectMasterFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules() : array 
    {
        return [
            'name' => 'required|string|max:20|unique:project_master,name,'.$this->id
        ];
    }

    public function getRequestFields() : array
    {
        return [
            'name' => $this->name,
            'created_by' => Auth::user()->id,
        ];
    }
}
