<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Book;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function accounts(): View
    {
        return view('deshpord.AccountManagement');
    }

    public function addPublisher(): View
    {
        return view('deshpord.add_publisher');
    }

    public function addBook(): View
    {
        return view('deshpord.Add-book');
    }

    public function inventory(): View
    {
        return view('deshpord.AnnualInventory');
    }

    public function approvedRequests(): View
    {
        return view('deshpord.approved-books');
    }

    public function requests(): View
    {
        return view('deshpord.book-requests');
    }

    public function books(): View
    {
        return view('deshpord.BookManagement');
    }

    public function editPublisher(string $id): View
    {
        return view('deshpord.edit_publisher');
    }

    public function extensions(): View
    {
        return view('deshpord.Loanextension');
    }

    public function notifications(): View
    {
        return view('deshpord.notifiction');
    }

    public function publishers(): View
    {
        return view('deshpord.publishingHouse');
    }

    public function registerLoan(): View
    {
        return view('deshpord.RegisterLoan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
