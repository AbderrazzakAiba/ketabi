<?php

// UpdateUserRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule class
use App\Enums\UserRole;   // Import UserRole enum
use App\Enums\UserStatus; // Import UserStatus enum
use App\Models\User; // Import User model

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        // Only users with the 'update' ability on the specific User model can make this request
        $user = $this->route('user'); // Get the user model from the route
        return $this->user()->can('update', $user);
    }

    public function rules()
    {
        $userId = $this->route('user')->id_User; // Get the user ID from the route

        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'adress' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20', // Adjust max length as needed
            'email' => 'nullable|email|unique:users,email,' . $userId . ',id_User', // Exclude current user's email by id_User
            'password' => 'nullable|string|min:8', // Add password validation if allowed to update password here
            'status' => ['nullable', Rule::in(array_map(fn($case) => $case->value, UserStatus::cases()))], // Use UserStatus enum
            'role' => ['nullable', Rule::in(array_map(fn($case) => $case->value, UserRole::cases()))],     // Use UserRole enum
        ];
    }
}
