<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Professor extends Model
{
    use HasFactory;

    protected $table = 'professors';
    protected $primaryKey = 'id_User'; // Correct Primary Key
    public $incrementing = false;      // Primary key is not auto-incrementing
    public $timestamps = false;        // No created_at/updated_at columns

    protected $fillable = [
        'id_User',      // Match column name
        'affiliation',  // Add affiliation from migration and make it fillable
    ];

    // Define the relationship to the User model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_User', 'id_User'); // Correct foreign key and owner key
    }
}
