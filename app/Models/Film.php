<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $table = 'film'; //nom de la table dans la bdd

    protected $primaryKey = 'film_id'; // Spécifie que la clé primaire est "film_id"
    public $incrementing = true; // clé auto-incrémenté
    protected $keyType = 'int'; // Type de la clé primaire est entier

    //champs que je peux remplir avec 'create()' ou '$request->all()'
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

    //relations  film -> plusiseurs entrées dans le stock (inventory)
    public function inventories()
{
    return $this->hasMany(Inventory::class, 'film_id', 'film_Id');
}
public function rentals() //un film peut être loué plusieurs fois
{
    return $this->hasManyThrough(
        Rental::class, //modèle final que l'on veut atteindre : location
        Inventory::class, //table intérmédiaire (pivot): inventaire
        'film_id', // Clé étrangère sur la table "inventory"
        'inventory_id', // Clé étrangère sur la table "rental"
        'filmId', // Clé locale sur la table "film"
        'inventory_id' // Clé locale sur la table "inventory"
    );
}


}
