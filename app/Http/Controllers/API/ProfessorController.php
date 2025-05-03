<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfessorResource;
use App\Models\Professor;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait

class ProfessorController extends Controller
{
    use AuthorizesRequests; // Use the trait

    /**
     * عرض جميع الأساتذة.
     */
    public function index()
    {
        $this->authorize('viewAny', Professor::class); // Add authorization check

        $professors = Professor::with('user')->get();
        // استخدام ProfessorResource لتنسيق الاستجابة
        return ProfessorResource::collection($professors);
    }

    /**
     * عرض تفاصيل أستاذ واحد.
     */
    public function show(Professor $professor) // Use Route Model Binding
    {
        $this->authorize('view', $professor); // Add authorization check

        // Route Model Binding handles finding the professor or returning 404 automatically

        // استخدام ProfessorResource لتنسيق الاستجابة
        return new ProfessorResource($professor->load('user')); // Eager load user relationship
    }
}
