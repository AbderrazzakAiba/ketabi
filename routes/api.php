<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\BorrowController;
use App\Http\Controllers\API\CopyController;
use App\Http\Controllers\API\EditorController;
use App\Http\Controllers\API\EmployerController;
use App\Http\Controllers\API\EtudiantController;
use App\Http\Controllers\API\OrderLivController;
use App\Http\Controllers\API\ProfessorController;
use App\Http\Controllers\API\UserController;

// Public routes (Authentication)
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Protected routes (Require authentication via Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    // Standard API Resources
    Route::apiResource('books', BookController::class);
    Route::apiResource('copies', CopyController::class);
    Route::apiResource('editors', EditorController::class);
    Route::apiResource('orders', OrderLivController::class);

    // User management routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/status/{status}', [UserController::class, 'getUsersByStatus'])->name('byStatus');
        Route::get('/status/pending', [UserController::class, 'getPendingUsers'])->name('pending');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/status', [UserController::class, 'updateStatus'])->name('updateStatus');
        Route::patch('/{user}/changer-status', [UserController::class, 'changerStatut'])->name('changerStatut'); // ✔️
    });

    // Role-specific views
    Route::get('/professors', [ProfessorController::class, 'index'])->name('professors.index');
    Route::get('/professors/{professor}', [ProfessorController::class, 'show'])->name('professors.show');

    Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
    Route::get('/etudiants/{etudiant}', [EtudiantController::class, 'show'])->name('etudiants.show');

    Route::get('/employers', [EmployerController::class, 'index'])->name('employers.index');
    Route::get('/employers/{employer}', [EmployerController::class, 'show'])->name('employers.show');

    // Borrowing routes
    Route::post('/borrow', [BorrowController::class, 'store'])->name('borrow.store');
    Route::post('/return', [BorrowController::class, 'returnBook'])->name('borrow.return');
    Route::get('/borrows', [BorrowController::class, 'index'])->name('borrow.index');
    Route::get('/user/borrows', [BorrowController::class, 'userBorrows'])->name('borrow.user');
    Route::get('/borrows/{borrow}', [BorrowController::class, 'show'])->name('borrow.show');
});

// Fallback route for 404 API requests
Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
});

// Test route
Route::get('/test-route', function () {
    return response()->json(['message' => 'Test route works!']);
});
