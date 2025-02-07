<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;


class StoreController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8080/toad/store');
  
        return view('stores.store'); // Vue pour afficher les stors
        
    }
}

