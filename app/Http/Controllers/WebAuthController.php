<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class WebAuthController extends Controller
{
    public function showRegistrationForm(): View
    {
        return view('CreatACount');
    }
    public function showLoginForm(): View
{
    return view('Login');
}

}
