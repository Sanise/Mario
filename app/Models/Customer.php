<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Nom de la table associé dans la bdd
    protected $table = 'customer'; //on précise le nom de table (car par défaut laravel attends customers)

    // Clé primaire
    protected $primaryKey = 'customer_id'; //on définit la clé primaire

    // Champs modifiables (ou qu'on peut remplir)
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

    
    public $timestamps = false; 

    public function rentals()  //un client peut avoir plusieurs locations (one to many)
{
    return $this->hasMany(Rental::class, 'customer_id', 'customer_id'); //lien avec le modèle Rental 
}

}
