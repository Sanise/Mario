<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    use HasFactory;
    //liste des champs qu'on peut remplir 
    protected $fillable = [
        'title',
        'description',
        'genre',
        'epoque',
        'lastUpdate',
    ];
}
