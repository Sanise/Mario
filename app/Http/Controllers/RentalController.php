<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    /**
     * Affiche la liste des clients avec pagination.
     */
    public function index()
    {
        // Récupérer les clients avec pagination (10 clients par page)
        $customers = Customer::paginate(10);

        // Retourner la vue avec la liste des clients paginés
        return view('rentals.index', ['customers' => $customers]);
    }

    /**
     * Recherche les clients en fonction du texte saisi par l'utilisateur (AJAX).
     */
    public function searchCustomers(Request $request)
    {
        $query = trim($request->input('query')); // Nettoie les espaces inutiles

        if (!$query) {
            return response()->json([]); // Retourne un tableau vide si aucun terme de recherche n'est fourni
        }

        $customers = Customer::where('first_name', 'LIKE', "%{$query}%")
            ->orWhere('last_name', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($customers);
    }
}
