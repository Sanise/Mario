<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

class StoreController extends Controller
{
    public function index()
    {
        $url = env('ENV_URL').':'.env('ENV_PORT').'/toad/store';
        $response = Http::get($url);

        return view('stores.store'); // Vue pour afficher les stores
    }
}