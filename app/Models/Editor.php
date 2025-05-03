<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Editor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'editors';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_editor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_ed',
        'adress_ed',
        'city_ed',
        'email_ed',
        'tel_ed',
    ];

    /**
     * Get the books associated with the editor.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'id_editor', 'id_editor');
    }
}
