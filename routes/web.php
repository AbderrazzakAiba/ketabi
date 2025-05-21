<?php

use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\BorrowController;
use App\Http\Controllers\API\AdminController;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\API\PageController as WebPageController;
use App\Http\Controllers\API\AuthController as WebAuthController;



// Define routes for web pages
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [WebPageController::class, 'index'])->name('about');
Route::get('/books/{id}', [BookController::class, 'show'])->name('book.show');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/borrowed', [BorrowController::class, 'index'])->name('borrowed.index');
Route::get('/register', [WebAuthController::class, 'showRegistrationForm'])->name('register.form');
Route::get('/home', [HomeController::class, 'dashboard'])->name('home');
Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/mybooks', [BookController::class, 'myBooks'])->name('mybooks.index');

Route::prefix('admin')->group(function () {
    Route::get('/accounts', [AdminController::class, 'accounts'])->name('admin.accounts');
    Route::get('/publishers/add', [AdminController::class, 'addPublisher'])->name('admin.publishers.add');
    Route::get('/books/add', [AdminController::class, 'addBook'])->name('admin.books.add');
    Route::get('/inventory', [AdminController::class, 'inventory'])->name('admin.inventory');
    Route::get('/requests/approved', [AdminController::class, 'approvedRequests'])->name('admin.requests.approved');
    Route::get('/requests', [AdminController::class, 'requests'])->name('admin.requests');
    Route::get('/books', [AdminController::class, 'books'])->name('admin.books');
    Route::get('/publishers/{id}/edit', [AdminController::class, 'editPublisher'])->name('admin.publishers.edit');
    Route::get('/extensions', [AdminController::class, 'extensions'])->name('admin.extensions');
    Route::get('/admin/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::get('/admin/publishers', [AdminController::class, 'publishers'])->name('admin.publishers');
    Route::get('/admin/loans/register', [AdminController::class, 'registerLoan'])->name('admin.loans.register');
});
