<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\BookStatus; // Import the Enum

class Book extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_book';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'auteur',
        'num_page',
        'num_RGE',
        'category',
        'quantite',
        'etat_liv',
        'id_editor',
        'image_path',
        'pdf_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'etat_liv' => BookStatus::class, // Cast etat_liv to BookStatus Enum
    ];

    /**
     * Get the editor that owns the book.
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(Editor::class, 'id_editor', 'id_editor');
    }

    /**
     * Get the copies for the book.
     */
    public function copies(): HasMany
    {
        // We will create the Copy model next
        return $this->hasMany(Copy::class, 'id_book', 'id_book');
    }

     /**
     * Get the orders for the book.
     */
    public function orders(): HasMany
    {
        // We will create the OrderLiv model later
        return $this->hasMany(OrderLiv::class, 'id_book', 'id_book');
    }
}
