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
            'basic_details.name' => 'required|unique:users,name,' . $this->basic_details['id'] ?? 0,
            'basic_details.first_name' => 'required',
            'basic_details.last_name' => 'required',
            'basic_details.email' => 'required|email|unique:users,email,' . $this->basic_details['id'] ?? 0,
            'basic_details.mobile' => 'required|numeric',
            'basic_details.gender' => 'required',
            'basic_details.role_id' => 'required',
            'basic_details.designation_id' => 'required',

            'address_details.state' => 'required',
            'address_details.city' => 'required',
            'address_details.pincode' => 'required',
            'address_details.address_line_1' => 'required',

            'educations.*.degree_name' => 'required',
            'educations.*.university_name' => 'required',
            'educations.*.starting_year' => 'required',
            'educations.*.ending_year' => 'required_if:educations.*.is_pursuing,0',

            'experiences.*.job_title' => 'required',
            'experiences.*.joining_date' => 'required',
            'experiences.*.leaving_date' => 'required',
        ];

        if($this->basic_details['id'] == '' || $this->basic_details['id'] == null) {
            $rules['basic_details.profile_image'] = 'required|file|mimes:jpeg,png|max:2000';
            $rules['basic_details.password'] = 'required|min:6|max:8';
            $rules['basic_details.confirm_password'] = 'required_with:basic_details.password|same:basic_details.password';

            $rules['documents.addhar_card'] = 'required|file|mimes:pdf,png,jpeg,jpg|max:2048';
            $rules['documents.pan_card'] = 'required|file|mimes:pdf,png,jpeg,jpg|max:2048';
            $rules['documents.passbook_front_page'] = 'required|file|mimes:pdf,png,jpeg,jpg|max:2048';
            $rules['documents.address_proof'] = 'required|file|mimes:pdf,png,jpeg,jpg|max:2048';
        } else {
            if (!empty($this->basic_details['password'])) {
                $rules['basic_details.password'] = 'required_if:basic_details.id,null|nullable|min:6';
                $rules['basic_details.confirm_password'] = 'required_with:basic_details.password|same:basic_details.password';
            }

            $rules['documents.addhar_card'] = 'nullable|file|mimes:pdf,png,jpeg,jpg|max:2048';
            $rules['documents.pan_card'] = 'nullable|file|mimes:pdf,png,jpeg,jpg|max:2048';
            $rules['documents.passbook_front_page'] = 'nullable|file|mimes:pdf,png,jpeg,jpg|max:2048';
            $rules['documents.address_proof'] = 'nullable|file|mimes:pdf,png,jpeg,jpg|max:2048';
        }

        if($this->profile_image) {
            $rules['basic_details.profile_image'] = 'file|mimes:jpeg,png|max:2000';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'basic_details.name.required' => 'The name field is required.',
            'basic_details.name.unique' => 'The name is already exist.',
            'basic_details.first_name.required' => 'The first name field is required.',
            'basic_details.last_name.required' => 'The last name field is required.',

            'basic_details.email.required' => 'The email field is required.',
            'basic_details.email.email' => 'Invalid email.',
            'basic_details.email.unique' => 'The email is already exist.',

            'basic_details.mobile.required' => 'The mobile number field is required.',
            'basic_details.mobile.numeric' => 'The mobile number must number.',

            'basic_details.gender.required' => 'The gender field is required.',
            'basic_details.role_id.required' => 'The role field is required.',
            'basic_details.designation_id.required' => 'The designation field is required.',

            'address_details.state.required' => 'The state field is required.',
            'address_details.city.required' => 'The city field is required.',
            'address_details.pincode.required' => 'The pincode field is required.',
            'address_details.address_line_1.required' => 'The address line 1 field is required.',

            'basic_details.profile_image.required' => 'The profile image is required.',
            'basic_details.profile_image.mimes' => 'The profile image type must jpg or png.',
            'basic_details.profile_image.max' => 'The profile image size less then 2 MB.',

            'basic_details.password.required' => 'The password field is required.',
            'basic_details.confirm_password.required_with' => 'The confirm password field is required.',
            'basic_details.confirm_password.same' => 'The confirm password dose not match.',

            'educations.*.degree_name.required' => 'The degree name field is required.',
            'educations.*.university_name.required' => 'The university name field is required.',
            'educations.*.starting_year.required' => 'The starting year field is required.',
            'educations.*.ending_year.required_if' => 'The ending year field is required.',

            'experiences.*.job_title.required' => 'The job title field is required.',
            'experiences.*.joining_date.required' => 'The joining date field is required.',
            'experiences.*.leaving_date.required' => 'The leaving date field is required.',

            'documents.addhar_card.required' => 'The addhar card is required.',
            'documents.addhar_card.mimes' => 'File type must jpg , png and pdf.',
            'documents.addhar_card.max' => 'File size less then 2 MB.',

            'documents.pan_card.required' => 'The pan card is required.',
            'documents.pan_card.mimes' => 'File type must jpg , png and pdf.',
            'documents.pan_card.max' => 'File size less then 2 MB.',

            'documents.passbook_front_page.required' => 'The passbook is required.',
            'documents.passbook_front_page.mimes' => 'File type must jpg , png and pdf.',
            'documents.passbook_front_page.max' => 'File size less then 2 MB.',

            'documents.address_proof.required' => 'The address proof is required.',
            'documents.address_proof.mimes' => 'File type must jpg , png and pdf.',
            'documents.address_proof.max' => 'File size less then 2 MB.',
        ];
    }

    public function basic_details(): array
    {
        $fields = [
            'name' => $this->basic_details['name'],
            'first_name' => $this->basic_details['first_name'],
            'last_name' => $this->basic_details['last_name'],
            'email' => $this->basic_details['email'],
            'mobile' => $this->basic_details['mobile'],
            'gender' => $this->basic_details['gender'],
            'designation_id' => $this->basic_details['designation_id'],
        ];

        if (!empty($this->basic_details['password'])) {
            $fields['password'] = bcrypt($this->basic_details['password']);
        }

        return $fields;
    }

    public function address_details(): array
    {
        $fields = [
            'state' => $this->address_details['state'],
            'city' => $this->address_details['city'],
            'pincode' => $this->address_details['pincode'],
            'address_line_1' => $this->address_details['address_line_1'],
            'address_line_2' => $this->address_details['address_line_2'],
        ];

        return $fields;
    }

    public function action(): string
    {
        return is_null($this->basic_details['id']) ? 'created' : 'updated';
    }
}
