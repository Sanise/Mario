<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\CssSelector\Node\FunctionNode;

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
 /*   public function searchCustomers(Request $request)  
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
    }*/

    public function searchCustomers(Request $request)  
{
    $query = trim($request->input('query')); // Nettoie les espaces inutiles

    if (!$query) {
        return response()->json([]); // Retourne un tableau vide si aucun terme de recherche n'est fourni
    }

    // Appel de l'API externe
    $response = Http::get('http://localhost:8080/toad/customer/all');

    if ($response->successful()) {
        $customers = collect($response->json());

        // Filtrer les résultats côté Laravel
        $filteredCustomers = $customers->filter(function ($customer) use ($query) {
            return stripos($customer['first_name'], $query) !== false || 
                   stripos($customer['last_name'], $query) !== false;
        })->take(10);

        return response()->json($filteredCustomers->values());
    }

    return response()->json(['error' => 'Impossible de récupérer les clients.'], 500);
}

}
