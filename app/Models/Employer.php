<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Employer extends Model
{
    use HasFactory;

    protected $table = 'employers';
    protected $primaryKey = 'id_User'; // Correct Primary Key
    public $incrementing = false;      // Primary key is not auto-incrementing
    public $timestamps = false;        // Correct, migration has no timestamps

    protected $fillable = [
        'id_User',      // Match column name (this is the only column in the migration)
    ];

    // Define the relationship to the User model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_User', 'id_User'); // Correct foreign key and owner key
    }
}
