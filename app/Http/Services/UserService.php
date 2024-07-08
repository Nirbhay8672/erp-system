<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Models\ProfileImage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function profileUpdate(array $usersDetails): void
    {
        $user = User::find((int) $usersDetails['user_id']);

        $user->fill([
            'name' => $usersDetails['name'],
            'first_name' => $usersDetails['first_name'],
            'last_name' => $usersDetails['last_name'],
            'email' => $usersDetails['email'],
        ]);

        if (!empty($usersDetails['password'])) {
            $user->password = bcrypt($usersDetails['password']);
        }

        $user->save();

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

        Storage::disk('public')->putFileAs("uploads/users/{$user->id}", $file, $file_name);

        $user->fill([
            'profile_path' => '/uploads/users/' . $user->id . '/' . $file_name,
        ])->save();
    }
}