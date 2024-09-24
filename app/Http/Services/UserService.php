<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Models\EmployeeDocumentsDetails;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function profileUpdate(array $usersDetails): void
    {
        $user = User::find((int) $usersDetails['user_id']);

        if ($usersDetails['profile_image'] ?? false) {
            $this->storeProfileImage($usersDetails['profile_image'], $user);
        }
    }

    public function storeProfileImage(UploadedFile $file, User $user): void
    {
        if ($user->profile_path != null) {
            Storage::disk('public')->delete($user->profile_path);
        }

        $file_name = time() . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->putFileAs("uploads/employees/{$user->id}", $file, $file_name);

        $user->fill([
            'profile_path' => '/uploads/employees/' . $user->id . '/' . $file_name,
        ])->save();
    }

    public function doucumentStore(UploadedFile $file , $document_type , $employee_id): void
    {
        $file_name = $document_type . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->putFileAs("uploads/employees/{$employee_id}", $file, $file_name);

        $document_detail = new EmployeeDocumentsDetails();

        $document_detail->fill([
            'employee_id' => $employee_id,
            'document_type' => $document_type,
            'document_file_name' => $file_name,
            'document_file_path' => '/uploads/employees/' . $employee_id . '/' . $file_name,
        ])->save();
    }
}
