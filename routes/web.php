<?php

use Illuminate\Support\Facades\Route;
use App\Models\Book;

Route::get('/', function () {
    $books = Book::all();
    return view('content.dashboard.welcome')
    ->with('books', $books);
});
