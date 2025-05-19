<?php

namespace App\Http\Controllers\API;

use App\Models\Borrow;
use App\Models\Copy;
use App\Models\User;
use App\Enums\LoanType;
use App\Enums\BorrowStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\BorrowResource;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Book;
use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    use AuthorizesRequests;

    /**
     * Request an extension for a borrow.
     */
    public function requestExtension(Request $request, Borrow $borrow)
    {
        // Check if the borrow is extendable
        if (strtolower($borrow->type->value) !== LoanType::EXTERNAL->value && strtolower($borrow->type->value) !== LoanType::ONLINE_RETURN->value) {
            Log::info('borrow->type: ' . $borrow->type);
            Log::info('LoanType::ONLINE_RETURN->value: ' . LoanType::ONLINE_RETURN->value);
            return response()->json(['message' => 'This borrow type is not extendable.'], 400);
        }

        // Check if the borrow is already returned or has a pending extension
        if (strtolower($borrow->status->value) === BorrowStatus::RETURNED->value || strtolower($borrow->status->value) === BorrowStatus::PENDING_EXTENSION->value) {
            return response()->json(['message' => 'This borrow cannot be extended.'], 400);
        }

        // Check if the borrow has already reached the maximum duration
        $originalDuration = $borrow->original_duration;
        if ($originalDuration >= 15) {
            return response()->json(['message' => 'This borrow cannot be extended further.'], 400);
        }

        // Validate the requested duration
        $validated = $request->validate([
            'duration' => 'required|integer|min:1',
        ]);

        $extensionDuration = $validated['duration'];
        $totalDuration = $originalDuration + $extensionDuration;

        if ($totalDuration > 15) {
            return response()->json(['message' => 'The extension duration exceeds the maximum allowed duration (15 days).'], 400);
        }

        // Calculate the new due date
        $newDueDate = Carbon::parse($borrow->borrow_date)->addDays($borrow->original_duration + $validated['duration']);

        // Update the borrow status and due date
        $borrow->status = BorrowStatus::PENDING_EXTENSION->value;
        $borrow->due_date = $newDueDate;
        $borrow->duration = $totalDuration;
        $borrow->save();

        return response()->json(['message' => 'Extension requested successfully. Waiting for approval.'], 200);
    }

    /**
     * Display a listing of the resource by type.
     */
    public function getByType(Request $request, $type)
    {
        // Validate the type
        $allowedTypes = array_map(fn($case) => $case->value, LoanType::cases());
        if (!in_array($type, $allowedTypes)) {
            return response()->json(['message' => 'Invalid borrow type.'], 400);
        }

        // Admin or Employee can view all borrows, other users can view their own
        $user = $request->user();
        if ($user->isAdmin() || $user->role === \App\Enums\UserRole::EMPLOYEE) {
            $borrows = Borrow::with(['user', 'copy.book'])->where('type', $type)->get();
        } else {
            $borrows = $user->borrows()->with(['user', 'copy.book'])->where('type', $type)->get();
        }

        return BorrowResource::collection($borrows);
    }

    /**
     * Display a listing of the resource by status.
     */
    public function getByStatus(Request $request, $status)
    {
        // Validate the status
        $allowedStatuses = array_map(fn($case) => $case->value, BorrowStatus::cases());
        if (!in_array($status, $allowedStatuses)) {
            return response()->json(['message' => 'Invalid borrow status.'], 400);
        }

        // Admin or Employee can view all borrows, other users can view their own
        $user = $request->user();
        if ($user->isAdmin() || $user->role === \App\Enums\UserRole::EMPLOYEE) {
            $borrows = Borrow::with(['user', 'copy.book'])->where('status', $status)->get();
        } else {
            $borrows = $user->borrows()->with(['user', 'copy.book'])->where('status', $status)->get();
        }

        return BorrowResource::collection($borrows);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Inject Request to get user
    {
        // Admin can view all borrows, other users can view their own
        $this->authorize('viewAny', Borrow::class);

        $user = $request->user(); // Get the authenticated user from the request

        if ($user->isAdmin() || $user->role === \App\Enums\UserRole::EMPLOYEE) {
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
     */
    public function store(StoreBorrowRequest $request) // Use the Form Request
    {
        // Authorization is handled in the Form Request's authorize method

        $validated = $request->validated(); // Validation is handled by the Form Request

        // Find the copy
        $copy = null;
        if (isset($validated['copy_id'])) {
            $copy = Copy::where('id_exemplaire', $validated['copy_id'])
                ->where('etat_copy_liv', \App\Enums\CopyStatus::AVAILABLE)
                ->first();

            if (!$copy) {
                return response()->json(['message' => 'هذه النسخة غير متاحة للاستعارة حاليًا.'], 400);
            }

            try {
                $copy->etat_copy_liv = \App\Enums\CopyStatus::ON_LOAN;
                $copy->save();
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error updating copy status: ' . $e->getMessage());
                return response()->json(['message' => 'حدث خطأ أثناء تحديث حالة النسخة.'], 500);
            }
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

        // Check if the user has any overdue borrows
        $overdueBorrows = $user->borrows()
            ->where('status', BorrowStatus::OVERDUE)
            ->count();

        if ($overdueBorrows > 0) {
            return response()->json(['message' => 'لا يمكنك استعارة كتاب جديد حتى تقوم بإرجاع الكتب المتأخرة.'], 400);
        }

        if ($currentBorrowsCount >= $maxBorrows) {
            return response()->json(['message' => "لقد وصلت إلى الحد الأقصى من الإعارات المسموح بها ({$maxBorrows} كتب)."], 400);
        }

        // Determine due date
        $dueDate = null;
        $duration = null;

        if (isset($validated['duration'])) {
            $duration = $validated['duration'];
            $dueDate = Carbon::now()->addDays($duration);
        } elseif ($validated['type'] === LoanType::IN_LIBRARY->value) {
             // Instant internal loan: no due date, set return date to borrow date
            $dueDate = now();
        } elseif ($validated['type'] === LoanType::ONLINE_DOWNLOAD->value) {
            // Online loan without return: no due date
            $dueDate = null;
        } else {
            // Handle other loan types if needed
            $dueDate = Carbon::now()->addDays(14); // Default duration
        }

        $borrowData = [
            'id_User' => $user->id_User,
            'type' => $validated['type'],
            'status' => BorrowStatus::ACTIVE, // Set status to active upon creation
            'borrow_date' => now(),
            'due_date' => $dueDate, // Set due date
            'duration' => $duration, // Store the duration
            'original_duration' => $duration, // Store the original duration
            'nbr_liv_empr' => $currentBorrowsCount + 1, // Update number of borrowed books
        ];

        if (isset($validated['copy_id'])) {
            $borrowData['id_exemplaire'] = $validated['copy_id'];
        }

        if (isset($validated['id_book'])) {
            $borrowData['id_book'] = $validated['id_book'];
        }

        // Create the borrow record
        $borrow = Borrow::create($borrowData);

        // Update copy status if it changed
        if ($copy && $copy->etat_copy_liv !== \App\Enums\CopyStatus::AVAILABLE) {
             $copy->etat_copy_liv = \App\Enums\CopyStatus::ON_LOAN;
             $copy->save();
        }

        // Return the created borrow resource
        return (new BorrowResource($borrow->load(['user', 'copy.book'])))->response()->setStatusCode(201);
    }

    /**
     * Handle book return.
     */
    public function returnBook(Request $request)
    {
        $validated = $request->validate([
            'borrow_id' => 'required|exists:borrows,id_pret',
        ]);

        $borrow = Borrow::findOrFail($validated['borrow_id']);

        // Check if the borrow is already returned
        if ($borrow->status === BorrowStatus::RETURNED) {
            return response()->json(['message' => 'هذه الإعارة تم إرجاعها بالفعل.'], 400);
        }

        $user = $request->user();

        if ($user->role === UserRole::EMPLOYEE) {
            //Allow Employee to return
        } else {
            return response()->json(['message' => 'غير مصرح للمستخدمين العاديين بإرجاع هذه الإعارة.'], 403);
        }

         // Find the associated copy
         $copy = $borrow->copy;

        // Update borrow status and return date
        $borrow->status = BorrowStatus::RETURNED;
        $borrow->return_date = now();
        $borrow->save();

        // Update copy status (only if it was marked as ON_LOAN)
        if ($copy && $copy->etat_copy_liv === \App\Enums\CopyStatus::ON_LOAN) {
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

        // Check if the request is to approve the extension
        $user = $request->user();
        if ($request->has('approve_extension') && $request->input('approve_extension') === true && $user->role === \App\Enums\UserRole::EMPLOYEE) {
            // Check if the borrow is in PENDING_EXTENSION status
            if (strtolower($borrow->status->value) !== BorrowStatus::PENDING_EXTENSION->value) {
                return response()->json(['message' => 'This borrow is not pending extension.'], 400);
            }

            // Calculate the new due date
            $newDueDate = Carbon::parse($borrow->borrow_date)->addDays($borrow->duration);

            // Update the borrow status and due date
            $borrow->status = BorrowStatus::ACTIVE->value;
            $borrow->due_date = $newDueDate;
            $borrow->save();

            return new BorrowResource($borrow->load(['user', 'copy.book']));
        } else if ($request->has('approve_extension') && $request->input('approve_extension') === false && $user->role === \App\Enums\UserRole::EMPLOYEE) {
            // Check if the borrow is in PENDING_EXTENSION status
            if (strtolower($borrow->status->value) !== BorrowStatus::PENDING_EXTENSION->value) {
                return response()->json(['message' => 'This borrow is not pending extension.'], 400);
            }

            // Update the borrow status to ACTIVE
            $borrow->status = BorrowStatus::ACTIVE->value;
            $borrow->due_date = $borrow->original_due_date;
            $borrow->duration = $borrow->original_duration;
            $borrow->save();

            return new BorrowResource($borrow->load(['user', 'copy.book']));
        }

        $borrow->update($validated);

         return new BorrowResource($borrow->load(['user', 'copy.book']));
     }

     /**
      * Remove the specified resource from storage.
      */
     public function destroy(Borrow $borrow) // Use Route Model Binding
    {
        // Optional: Check if the borrow is active before deleting
        if ($borrow->status === BorrowStatus::ACTIVE) {
             return response()->json(['message' => 'لا يمكن حذف إعارة نشطة.'], 400);
        }

        $this->authorize('delete', $borrow);
        $borrow->delete();

        return response()->json(['message' => 'Borrow deleted successfully.']);
    }

    // Add methods for approving/rejecting borrow requests if a request/approval workflow is needed
    // public function approveBorrow(Borrow $borrow) { ... }
    // public function rejectBorrow(Borrow $borrow) { ... }
}
