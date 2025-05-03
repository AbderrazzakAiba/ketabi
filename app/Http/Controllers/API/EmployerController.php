<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;
use App\Models\User; // Import User model
use App\Enums\UserRole; // Import UserRole enum
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource; // Assuming you will create this resource
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait

class EmployerController extends Controller
{
    use AuthorizesRequests; // Use the trait

    public function __construct()
    {
        // Apply auth:sanctum middleware to all methods in this controller
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the employees (Users with employee role).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Authorize viewing any employer using EmployerPolicy
        $this->authorize('viewAny', Employer::class);

        // Fetch Users with the employee role
        $employees = User::where('role', UserRole::EMPLOYEE)->get();
        // Use UserResource to format the output
        return UserResource::collection($employees);
    }

    /**
     * Display the specified employee (User with employee role).
     *
     * @param  \App\Models\Employer  $employer Use Route Model Binding for Employer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Employer $employer) // Use Route Model Binding for Employer
    {
        // Authorize viewing this specific employer using EmployerPolicy
        $this->authorize('view', $employer);

        // Load the associated User model for the resource
        $employer->load('user');

        // Use UserResource to format the output (assuming EmployerResource extends UserResource or handles User relationship)
        // If EmployerResource exists and is appropriate, use that instead.
        // Based on open tabs, UserResource is used, so we'll stick with that for now.
        return new UserResource($employer->user);
    }

    // Removed placeholder store, update, and destroy methods as user management
    // is intended to be handled in UserController with proper authorization.
}
