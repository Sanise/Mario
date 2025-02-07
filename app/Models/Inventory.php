<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Nom de la table
    protected $table = 'inventory';

    // Clé primaire
    protected $primaryKey = 'inventory_id';

    public $timestamps = false;

    // Relation avec les films
    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id', 'film_id');
    }
}

