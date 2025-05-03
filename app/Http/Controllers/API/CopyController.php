<?php

namespace App\Http\Controllers\API;

use App\Models\Copy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CopyResource;
use App\Enums\CopyStatus; // Import the Enum
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait
use App\Http\Requests\StoreCopyRequest; // Import the Form Request
use App\Http\Requests\UpdateCopyRequest; // Import the Update Form Request

class CopyController extends Controller
{
    use AuthorizesRequests; // Use the trait

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Copy::class);

        $copies = Copy::all();
        return CopyResource::collection($copies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCopyRequest $request) // Use the Form Request
    {
        $this->authorize('create', Copy::class);

        $validated = $request->validated();

        $copy = Copy::create($validated);

        return new CopyResource($copy);
    }

    /**
     * Display the specified resource.
     */
    public function show(Copy $copy) // Use Route Model Binding
    {
        $this->authorize('view', $copy);

        return new CopyResource($copy);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCopyRequest $request, Copy $copy) // Use Route Model Binding
    {
        $this->authorize('update', $copy);

        $validated = $request->validated();

        $copy->update($validated);

        return new CopyResource($copy);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Copy $copy) // Use Route Model Binding
    {
        $this->authorize('delete', $copy);

        // Optional: Check if there are any active borrows for this copy
        if ($copy->borrows()->where('status', \App\Enums\BorrowStatus::ACTIVE)->exists()) {
             return response()->json(['message' => 'لا يمكن حذف النسخة لوجود إعارات نشطة مرتبطة بها.'], 400);
        }

        $copy->delete();

        return response()->json(['message' => 'Copy deleted successfully.']);
    }
}
