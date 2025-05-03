<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\CopyStatus; // Import the Enum

class Copy extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_exemplaire';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date_achat',
        'etat_copy_liv',
        'id_book', // Foreign key
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'etat_copy_liv' => CopyStatus::class, // Cast etat_copy_liv to CopyStatus Enum
        'date_achat' => 'date', // Cast date_achat to date object
    ];

    /**
     * Get the book that this copy belongs to.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'id_book', 'id_book');
    }

    /**
     * Get the borrows associated with this copy.
     */
    public function borrows(): HasMany
    {
        // We will create the Borrow model later
        return $this->hasMany(Borrow::class, 'id_exemplaire', 'id_exemplaire');
    }
}
