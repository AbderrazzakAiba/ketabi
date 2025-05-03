<?php

// StoreUserRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule class
use App\Enums\UserRole;   // Import UserRole enum
use App\Enums\UserStatus; // Import UserStatus enum
use App\Models\User; // Import User model

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        // Only users with the 'create' ability on the User model can make this request
        return $this->user()->can('create', User::class);
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'adress' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20', // Adjust max length as needed
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8', // Adjust min length as needed
            'status' => ['required', Rule::in(array_map(fn($case) => $case->value, UserStatus::cases()))], // Use UserStatus enum
            'role' => ['required', Rule::in(array_map(fn($case) => $case->value, UserRole::cases()))],     // Use UserRole enum
        ];
    }
}
