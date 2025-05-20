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
        'id_User',
        'title',
        'auteur',
        'category',
        'order_date',
        'status',
    ];

    protected $casts = [
        'order_date' => 'date',           // Correct attribute name
        'status' => OrderStatus::class,   // Correct attribute name
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_User');
    }
}
