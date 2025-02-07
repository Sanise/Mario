<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $table = 'film';

    protected $primaryKey = 'film_id'; // Spécifie que la clé primaire est "film_id"
    public $incrementing = true; // Si la clé est incrémentale (ce qui semble être le cas)
    protected $keyType = 'int'; // Type de la clé primaire

    protected $fillable = [
        'title',
        'description',
        'release_year',
        'language_id',
        'original_language_id',
        'rental_duration',
        'rental_rate',
        'length',
        'replacement_cost',
        'rating',
        'special_features',
        'last_update',
        'id_director',
    ];
    public function inventories()
{
    return $this->hasMany(Inventory::class, 'film_id', 'film_Id');
}
public function rentals()
{
    return $this->hasManyThrough(
        Rental::class,
        Inventory::class,
        'film_id', // Clé étrangère sur la table "inventory"
        'inventory_id', // Clé étrangère sur la table "rental"
        'filmId', // Clé locale sur la table "film"
        'inventory_id' // Clé locale sur la table "inventory"
    );
}


}
