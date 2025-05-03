<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'etudiants';
    protected $primaryKey = 'id_User';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_User',
        'matricule',        // 👈 تمت إضافته هنا
        'level',
        'academic_year',
        'speciality',
    ];

    protected $casts = [
        'academic_year' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_User', 'id_User');
    }
}
