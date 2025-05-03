<?php

namespace App\Models;

use App\Enums\BorrowStatus;
use App\Enums\LoanType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Add HasFactory
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Borrow extends Model
{
    use HasFactory; // Add HasFactory trait

    protected $table = 'borrows';
    protected $primaryKey = 'id_pret'; // Correct Primary Key
    // Remove public $timestamps = false; as migration has timestamps

    protected $fillable = [
        'id_User',          // Correct foreign key name
        'id_exemplaire',    // Correct foreign key name
        'type',             // Correct column name
        'borrow_date',      // Correct column name
        'return_date',      // Correct column name
        'due_date',         // Add due_date
        'status',           // Correct column name
        'nbr_liv_empr',     // Add based on previous decision
    ];

    protected $casts = [
        'type' => LoanType::class,         // Correct attribute name
        'status' => BorrowStatus::class,   // Correct attribute name
        'borrow_date' => 'date',           // Correct attribute name
        'return_date' => 'date',           // Correct attribute name
        'due_date' => 'date',              // Add due_date cast
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_User', 'id_User'); // Correct keys
    }

    public function copy(): BelongsTo
    {
        return $this->belongsTo(Copy::class, 'id_exemplaire', 'id_exemplaire'); // Correct keys
    }
}
