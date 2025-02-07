<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Nom de la table
    protected $table = 'customer';

    // Clé primaire
    protected $primaryKey = 'customer_id';

    // Champs modifiables
    protected $fillable = [
        'store_id',
        'first_name',
        'last_name',
        'email',
        'address_id',
        'active',
        'create_date',
        'last_update',
        'password',
        'age',
    ];

    // Désactiver les timestamps automatiques si nécessaire
    public $timestamps = false;

    public function rentals()
{
    return $this->hasMany(Rental::class, 'customer_id', 'customer_id');
}

}
