<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|min:1|max:20',
            'email' => 'required|string|email',
            'phone_number' => 'required|numeric|digits:10',
            'website_name' => 'required|string|min:1|unique:members,website_name,' . $this->id,
            'website_link' => 'required|string|min:1|unique:members,website_link,' . $this->id,
            'otech_username' => 'required|string|min:1',
            'otech_password' => 'required|string|min:1',
        ];
    }

    public function fields(): array
    {
        $fields = [
            'username' => $this->username,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'website_name' => $this->website_name,
            'website_link' => $this->website_link,
            'wp_username' => $this->wp_username,
            'wp_password' => $this->wp_password,
            'otech_username' => $this->otech_username,
            'otech_password' => $this->otech_password,
        ];

        return $fields;
    }

    public function action(): string
    {
        return is_null($this->id) ? 'created' : 'updated';
    }
}