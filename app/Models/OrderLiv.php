<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Add HasFactory
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class OrderLiv extends Model
{
    use HasFactory; // Add HasFactory trait

    protected $table = 'order_liv';
    protected $primaryKey = 'id_demande'; // Correct Primary Key

    protected $fillable = [
        'id_User',      // Correct foreign key name
        'id_book',      // Correct foreign key name
        'order_date',   // Correct column name
        'status',       // Correct column name
    ];

    protected $casts = [
        'order_date' => 'date',           // Correct attribute name
        'status' => OrderStatus::class,   // Correct attribute name
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_User', 'id_User'); // Correct keys
    }

    public function book(): BelongsTo


    {
        return $this->belongsTo(Book::class, 'id_book', 'id_book'); // Correct keys
    }
}
