<?php

namespace App\Services;

use App\Models\User;
use App\Models\Professor;
use App\Models\Etudiant;
use App\Models\Employer;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthService
{
    /**
     * Register a new user with their role-specific data.
     *
     * @param array $validatedData
     * @return User
     * @throws Exception
     */
    public function registerUser(array $validatedData): User
    {
        if (empty($validatedData['role']) || !in_array($validatedData['role'], array_column(UserRole::cases(), 'value'))) {
            throw ValidationException::withMessages(['role' => 'الدور المحدد غير صالح.']);
        }

        $role = UserRole::from($validatedData['role']);

        $userData = Arr::only($validatedData, [
            'first_name', 'last_name', 'adress', 'city', 'phone_number', 'email'
        ]);
        $userData['password'] = Hash::make($validatedData['password']);
        $userData['role'] = $role;
        $userData['status'] = UserStatus::PENDING;

        DB::beginTransaction();

        try {
            $user = User::create($userData);

            switch ($role) {
                case UserRole::PROFESSOR:
                    $professorData = Arr::only($validatedData, ['affiliation']);
                    $professorData['id_User'] = $user->id_User;
                    Professor::create($professorData);
                    break;

                case UserRole::STUDENT:
                    $etudiantData = Arr::only($validatedData, [
                        'matricule', 'level', 'academic_year', 'speciality'
                    ]);
                    $etudiantData['id_User'] = $user->id_User;
                    Etudiant::create($etudiantData);
                    break;

                case UserRole::EMPLOYEE:
                    Employer::create(['id_User' => $user->id_User]);
                    break;
            }

            DB::commit();

            return $user;

        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('فشل تسجيل المستخدم. يرجى المحاولة مرة أخرى.');
        }
    }
}
