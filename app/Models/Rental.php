<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    // Nom de la table
    protected $table = 'rental';

    // Clé primaire
    protected $primaryKey = 'rental_id';

    // Champs modifiables
    protected $fillable = [
        'rental_date',
        'inventory_id',
        'customer_id',
        'return_date',
        'staff_id',
        'last_update',
    ];

    // Désactiver les timestamps automatiques
    public $timestamps = false;

    // Relation avec l'inventaire
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'inventory_id');
    }

    // Relation avec le client
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
