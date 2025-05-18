<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Services\AuthService; // Import AuthService
use App\Enums\UserRole;      // Import UserRole for validation
use Illuminate\Support\Facades\Log; // For logging errors
use Exception;
use App\Http\Requests\RegisterUserRequest; // Import the new Form Request

class AuthController extends Controller
{
    protected AuthService $authService;

    // Inject AuthService via constructor
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // تسجيل مستخدم جديد
    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        try {
            $user = $this->authService->registerUser($validated);

            Log::info('Register route hit! User ID: ' . $user->id_User);

            return response()->json([
                'message' => 'تم إنشاء الحساب بنجاح. الحساب قيد المراجعة للموافقة.',
                'user_id' => $user->id_User
            ], 201);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);

        } catch (Exception $e) {
            Log::error('Registration failed in controller: ' . $e->getMessage());
            // Return a generic error response with the exception message
            return response()->json(['message' => 'فشل تسجيل المستخدم: ' . $e->getMessage()], 500);
        } catch (\Throwable $th) {
            // Temporary diagnostic for error clarity
            Log::error('Registration failed in controller: ' . $th->getMessage());
            return response()->json(['message' => 'فشل تسجيل المستخدم: ' . $th->getMessage()], 500);
        }
    }

    // تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['بيانات الدخول غير صحيحة.'],
            ]);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if user account is approved
        if ($user->status !== \App\Enums\UserStatus::APPROVED) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => ['الحساب غير مفعل أو معلق. يرجى مراجعة الإدارة.'],
            ]);
        }

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return successful login response
        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        // Delete the current access token
        $request->user()->currentAccessToken()->delete();

        // Return success message
        return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
    }
}
