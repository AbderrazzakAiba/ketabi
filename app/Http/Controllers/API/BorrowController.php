<?php

namespace App\Http\Controllers\API;

use App\Models\Borrow;
use App\Models\Copy;
use App\Models\User; // Import User model
use App\Enums\LoanType;
use App\Enums\BorrowStatus;
use App\Enums\UserRole; // Import UserRole
use App\Enums\UserStatus; // Import UserStatus
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BorrowResource;
use Illuminate\Validation\Rule; // Import Rule
use Carbon\Carbon; // Import Carbon for date calculations
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait
use App\Http\Requests\StoreBorrowRequest; // Import the Store Form Request
use App\Http\Requests\UpdateBorrowRequest; // Import the Update Form Request
use Illuminate\Support\Facades\Auth; // Import Auth facade

class BorrowController extends Controller
{
    use AuthorizesRequests; // Use the trait

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Inject Request to get user
    {
        // Admin can view all borrows, other users can view their own
        $this->authorize('viewAny', Borrow::class);

        $user = $request->user(); // Get the authenticated user from the request

        if ($user->isAdmin()) {
            $borrows = Borrow::with(['user', 'copy.book'])->get();
        } else {
            $borrows = $user->borrows()->with(['user', 'copy.book'])->get();
        }

        return BorrowResource::collection($borrows);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Borrow $borrow) // Inject Request to get user
    {
        // Admin can view any borrow, other users can view their own
        $this->authorize('view', $borrow);

        return new BorrowResource($borrow->load(['user', 'copy.book']));
    }

    /**
     * Store a newly created resource in storage.
     * This method will handle the initial borrow request/creation.
     * Approval logic will be handled separately if needed.
     */
    public function store(StoreBorrowRequest $request) // Use the Form Request
    {
        // Authorization is handled in the Form Request's authorize method

        $validated = $request->validated(); // Validation is handled by the Form Request

        // Find the copy
        $copy = Copy::findOrFail($validated['copy_id']);

        // Check copy status
        if ($copy->etat_copy_liv !== \App\Enums\CopyStatus::AVAILABLE) {
            return response()->json(['message' => 'هذه النسخة غير متاحة للاستعارة حاليًا.'], 400);
        }

        // Check borrowing limits based on user role
        $user = $request->user(); // Get the authenticated user from the request
        $currentBorrowsCount = $user->borrows()->where('status', BorrowStatus::ACTIVE)->count();
        $maxBorrows = 0;

        switch ($user->role) {
            case UserRole::STUDENT:
                $maxBorrows = 3;
                break;
            case UserRole::PROFESSOR:
                $maxBorrows = 5;
                break;
            case UserRole::EMPLOYEE:
                $maxBorrows = 3; // Employee limit for borrowing
                break;
            // Admin might not typically borrow, or have a different limit/process.
            // Assuming Admins can borrow with employee limit for now.
            case UserRole::ADMIN:
                 $maxBorrows = 3;
                 break;
        }

        if ($currentBorrowsCount >= $maxBorrows) {
            return response()->json(['message' => "لقد وصلت إلى الحد الأقصى من الإعارات المسموح بها ({$maxBorrows} كتب)."], 400);
        }

        // Determine due date and update copy status based on loan type
        $dueDate = null;
        $copyStatus = $copy->etat_copy_liv; // Default to current status

        switch ($validated['type']) {
            case LoanType::EXTERNAL->value:
                // External loan: set due date (e.g., 14 days) and mark copy as on loan
                $dueDate = Carbon::now()->addDays(14);
                $copyStatus = \App\Enums\CopyStatus::ON_LOAN;
                break;
            case LoanType::ONLINE_RETURN->value:
                // Online loan with return: set due date (e.g., 7 days) and mark copy as on loan
                $dueDate = Carbon::now()->addDays(7);
                $copyStatus = \App\Enums\CopyStatus::ON_LOAN;
                break;
            case LoanType::IN_LIBRARY->value: // Corrected case name
                // Instant internal loan: no due date, copy status remains available (or a temporary status if needed)
                $dueDate = null;
                // Copy status remains AVAILABLE or similar, as it's read inside and returned immediately.
                // No change needed to $copyStatus if AVAILABLE is the default.
                break;
            case LoanType::ONLINE_DOWNLOAD->value: // Corrected case name
                // Online loan without return: no due date, copy status remains available (or a 'DOWNLOADED' status if needed)
                $dueDate = null;
                // Copy status remains AVAILABLE or similar for permanent download.
                // No change needed to $copyStatus if AVAILABLE is the default.
                break;
        } // Added missing closing brace for switch

        // Create the borrow record
        $borrow = Borrow::create([
            'id_User' => $user->id_User,
            'id_exemplaire' => $copy->id_exemplaire,
            'type' => $validated['type'],
            'status' => BorrowStatus::ACTIVE, // Set status to active upon creation
            'borrow_date' => now(),
            'due_date' => $dueDate, // Set due date
            'nbr_liv_empr' => $currentBorrowsCount + 1, // Update number of borrowed books
        ]);

        // Update copy status if it changed
        if ($copy->etat_copy_liv !== $copyStatus) {
             $copy->etat_copy_liv = $copyStatus;
             $copy->save();
        }

        // Return the created borrow resource
        return new BorrowResource($borrow->load(['user', 'copy.book']));
    }

    /**
     * Handle book return.
     */
    public function returnBook(Request $request, Borrow $borrow) // Use Route Model Binding
    {
        // Authorization: Only Employee can return books
        $this->authorize('returnBook', $borrow);

        // Check if the borrow is already returned
        if ($borrow->status === BorrowStatus::RETURNED) {
            return response()->json(['message' => 'هذه الإعارة تم إرجاعها بالفعل.'], 400);
        }

        // Find the associated copy
        $copy = $borrow->copy;

        // Update borrow status and return date
        $borrow->status = BorrowStatus::RETURNED;
        $borrow->return_date = now();
        $borrow->save();

        // Update copy status (only if it was marked as ON_LOAN)
        if ($copy->etat_copy_liv === \App\Enums\CopyStatus::ON_LOAN) {
             $copy->etat_copy_liv = \App\Enums\CopyStatus::AVAILABLE;
             $copy->save();
        }
        // For other loan types (INTERNAL, ONLINE_NO_RETURN), copy status might not need changing here

        // Return the updated borrow resource
        return new BorrowResource($borrow->load(['user', 'copy.book']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBorrowRequest $request, Borrow $borrow) // Use Form Request and Route Model Binding
    {
        // Authorization and validation are handled by the Form Request
        $validated = $request->validated();

        $borrow->update($validated);

        return new BorrowResource($borrow->load(['user', 'copy.book']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrow $borrow) // Use Route Model Binding
    {
        // Authorization: Only Employee can delete a borrow
        $this->authorize('delete', $borrow);

        // Optional: Check if the borrow is active before deleting
        if ($borrow->status === BorrowStatus::ACTIVE) {
             return response()->json(['message' => 'لا يمكن حذف إعارة نشطة.'], 400);
        }

        $borrow->delete();

        return response()->json(['message' => 'Borrow deleted successfully.']);
    }

    // Add methods for approving/rejecting borrow requests if a request/approval workflow is needed
    // public function approveBorrow(Borrow $borrow) { ... }
    // public function rejectBorrow(Borrow $borrow) { ... }
}
