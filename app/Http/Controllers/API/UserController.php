<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait
use App\Models\Employer; // Import Employer model
use App\Models\Etudiant; // Import Etudiant model
use App\Models\Professor; // Import Professor model
use App\Enums\UserRole; // Import UserRole enum

class UserController extends Controller
{
    use AuthorizesRequests; // Use the trait

    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();
        return UserResource::collection($users);
    }

    public function show(User $user) // Use Route Model Binding
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $user = User::create($request->validated());

        // Create associated record based on role
        switch ($user->role) {
            case UserRole::EMPLOYEE:
                Employer::create(['id_User' => $user->id_User]);
                break;
            case UserRole::STUDENT:
                Etudiant::create(['id_User' => $user->id_User]);
                break;
            case UserRole::PROFESSOR:
                Professor::create(['id_User' => $user->id_User]);
                break;
            default:
                // No associated record needed for Admin or other roles
                break;
        }

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user) // Use Route Model Binding
    {
        $this->authorize('update', $user);

        $oldRole = $user->role; // Get the old role before updating

        $user->update($request->validated());

        $newRole = $user->role; // Get the new role after updating

        // Handle associated records based on role change
        if ($oldRole !== $newRole) {
            // Delete old associated record if it existed
            switch ($oldRole) {
                case UserRole::EMPLOYEE:
                    $user->employer()->delete();
                    break;
                case UserRole::STUDENT:
                    $user->etudiant()->delete();
                    break;
                case UserRole::PROFESSOR:
                    $user->professor()->delete();
                    break;
                default:
                    break;
            }

            // Create new associated record if the new role requires it
            switch ($newRole) {
                case UserRole::EMPLOYEE:
                    Employer::create(['id_User' => $user->id_User]);
                    break;
                case UserRole::STUDENT:
                    Etudiant::create(['id_User' => $user->id_User]);
                    break;
                case UserRole::PROFESSOR:
                    Professor::create(['id_User' => $user->id_User]);
                    break;
                default:
                    break;
            }
        }

        $user->update($request->validated());
        return new UserResource($user);
    }

    public function destroy(User $user) // Use Route Model Binding
    {
        $this->authorize('delete', $user);

        // Delete associated record based on role before deleting the user
        switch ($user->role) {
            case UserRole::EMPLOYEE:
                $user->employer()->delete();
                break;
            case UserRole::STUDENT:
                $user->etudiant()->delete();
                break;
            case UserRole::PROFESSOR:
                $user->professor()->delete();
                break;
            default:
                break;
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function changerStatut(Request $request, User $user) // Use Route Model Binding
    {
        $this->authorize('updateStatus', $user);

        $request->validate([
            'statut' => 'required|in:' . implode(',', array_map(fn($case) => $case->value, UserStatus::cases())),
        ]);

        $user->status = $request->input('statut');
        $user->save();

        return new UserResource($user);
    }

    public function getPendingUsers()
    {
        $this->authorize('viewPending', User::class);

        $users = User::where('status', UserStatus::PENDING->value)->get();
        return UserResource::collection($users);
    }

    public function getUsersByStatus($status)
    {
        $this->authorize('viewAny', User::class); // Authorize viewing any user, then filter

        if (!in_array($status, array_map(fn($case) => $case->value, UserStatus::cases()))) {
            return response()->json(['error' => 'Invalid status'], 400);
        }

        $users = User::where('status', $status)->get();
        return UserResource::collection($users);
    }
}
