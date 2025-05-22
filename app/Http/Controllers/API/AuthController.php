<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

     public function showLoginForm(): View
    {
        return view('Login');
    }

    public function register(Request $request)
    {
       $request->validate([
    'first_name' => 'required',
    'last_name' => 'required',
    'address' => 'required',
    'city' => 'required',
    'phone' => 'required',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:6',
    'date_of_birth' => 'required',
    'place_of_birth' => 'required'
]);

        $user = User::create([
    'first_name' => $request->first_name,
    'last_name' => $request->last_name,
    'adress' => $request->address, // اسم الحقل في قاعدة البيانات
    'city' => $request->city,
    'phone_number' => $request->phone,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'date_de_naissance' => $request->date_of_birth,
    'lieu_de_naissance' => $request->place_of_birth,
]);

        Log::info('User created: ' . json_encode($user));

        return response()->json(['success' => true, 'message' => 'تم إنشاء الحساب بنجاح!'], 201);
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        if ($user->status->value === 'approved') {
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'حسابك قيد المراجعة من الإدارة.'], 403);
        }
    } else {
        return response()->json(['message' => 'بيانات الدخول غير صحيحة'], 401);
    }
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
