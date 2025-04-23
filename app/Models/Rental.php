<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $table = 'rental';   // Nom de la table dans la bdd

    // Clé primaire
    protected $primaryKey = 'rental_id';

    // Champs modifiables
    protected $fillable = [
        'rental_date', //date de location
        'inventory_id', //ID de l'article loué (référence à la table inventory)
        'customer_id',//ID du client qui loue le film
        'return_date',//Date de retour prévue ou effective
        'staff_id',//ID de l'employé ayant enregistré la location
        'last_update',//Date de dernière mise à jours
    ];

    // Désactiver les timestamps automatiques
    public $timestamps = false;

    // Relation avec l'inventaire (inventory)
    public function inventory() 
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'inventory_id'); //chaque location appartient à un élément d'invetaire
    }

    // Relation avec le client (customer)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id'); //chaque location est faite par un client
    }
}
