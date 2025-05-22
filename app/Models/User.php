<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// Removed duplicate HasFactory import, it's already included in the 'use' statement below
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\UserRole;   // Import Enums
use App\Enums\UserStatus;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users'; // Explicitly define table name if needed, though Laravel usually infers it

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_User'; // Match the migration primary key

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'adress',
        'city',
        'phone_number',
        'email',
        'password',
        'role',   // Add role
        'status', // Add status
        'lieu_de_naissance', // Add lieu_de_naissance
        'date_de_naissance', // Add date_de_naissance
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,     // Cast role to UserRole Enum
            'status' => UserStatus::class, // Cast status to UserStatus Enum
            'date_de_naissance' => 'date', // Cast date_de_naissance to date
        ];
    }

    /**
     * Get the professor record associated with the user.
     */
    public function professor(): HasOne
    {
        // We will create the Professor model later
        return $this->hasOne(Professor::class, 'id_User', 'id_User');
    }

    /**
     * Get the etudiant record associated with the user.
     */
    public function etudiant(): HasOne
    {
        // We will create the Etudiant model later
        return $this->hasOne(Etudiant::class, 'id_User', 'id_User');
    }

    /**
     * Get the employer record associated with the user.
     */
    public function employer(): HasOne
    {
        // We will create the Employer model later
        return $this->hasOne(Employer::class, 'id_User', 'id_User');
    }

    /**
     * Get the borrows for the user.
     */
    public function borrows(): HasMany
    {
        // We will create the Borrow model later
        return $this->hasMany(Borrow::class, 'id_User', 'id_User');
    }

    /**
     * Get the orders placed by the user (assuming user places orders).
     */
    public function orders(): HasMany
    {
        // We will create the OrderLiv model later
        return $this->hasMany(OrderLiv::class, 'id_User', 'id_User');
    }

    // Helper methods to check roles easily
    public function isAdmin(): bool
    {
        return strtolower((string)$this->role->value) === strtolower(UserRole::ADMIN->value);
    }

    public function isEmployee(): bool
    {
        return strtolower((string)$this->role->value) === strtolower(UserRole::EMPLOYEE->value);
    }

    public function isStudent(): bool
    {
        return $this->role === UserRole::STUDENT;
    }

    /**
     * Determine if the user holds the role of a professor.
     *
     * @return bool True if the user is a professor, false otherwise.
     */

    public function isProfessor(): bool
    {
        return $this->role === UserRole::PROFESSOR;
    }

    // Helper method to check status
    public function isApproved(): bool
    {
        return $this->status === UserStatus::APPROVED;
    }
}
