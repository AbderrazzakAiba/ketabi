<?php

namespace App\Http\Controllers\API;

use App\Models\Etudiant;
use App\Http\Resources\EtudiantResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEtudiantRequest; // Import the Form Request (Note: Store method was removed, this import might not be needed)
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait

class EtudiantController extends Controller
{
    use AuthorizesRequests; // Use the trait

    // عرض جميع الطلبة
    public function index()
    {
        $this->authorize('viewAny', Etudiant::class); // Add authorization check

        $etudiants = Etudiant::all();
        return EtudiantResource::collection($etudiants); // استخدام `collection` لتحويل مجموعة من الكائنات
    }

    // عرض طالب واحد
    public function show(Etudiant $etudiant) // Use Route Model Binding
    {
        $this->authorize('view', $etudiant); // Add authorization check

        // Route Model Binding handles finding the etudiant or returning 404 automatically

        return new EtudiantResource($etudiant); // استخدام الـ `Resource` لتحويل الكائن
    }
}
