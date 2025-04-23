<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;


class RentalController extends Controller
{
    
    // Affiche la liste des clients (via API) et les films loués d'un client si un ID est spécifié avec pagination manuelle.
    
    public function index(Request $request)
{
    $envUrl = env('ENV_URL');
    $envPort = env('ENV_PORT');

        //appel de l'API pour récuper tous les clients 
    $response = Http::get($envUrl . $envPort . '/toad/customer/all');

    //    Si l'API échoue, rediriger vers la liste des films avec un message d'erreur
    if (!$response->successful()) {
        return redirect('/films')->withErrors(['message' => 'Impossible de récupérer les clients.']);
    }

    //convertir la réponse JSON en collection Laravel 
    $customers = collect($response->json());
    //Récupere un customerId si l'utilisateur en a selectionné un
    $customerId = $request->input('customerId');

    //Itialisation des variables pour la vue
    $selectedCustomer = null;
    $rentals = []; //Films loués par ce client 

    //si un client est sélectionné, récuperer ses locations 
    if ($customerId) {
        //chercge les clients séléctionné dans la collection
        $selectedCustomer = $customers->firstWhere('customerId', (int)$customerId);

        //Appel API pour récupérer les locations du client 
        $rentalResponse = Http::get($envUrl . $envPort . '/toad/rental/getInformationsByCustomerId/' . $customerId);

        if ($rentalResponse->successful()) {
            $rentals = $rentalResponse->json();
        }
    }

    //Envoie les données à la vue: liste des clients, clients séléctionné, locations
    return view('rentals.index', compact('customers', 'selectedCustomer', 'rentals'));
}

    

    //Permet de rechercher des clients en fonction de leur nom ou prénom
    public function searchCustomers(Request $request)
    {
        $query = trim($request->input('query')); //Texte saisi par l'utilisateur

        //si la requête est vide, ne rien faire
        if (!$query) {
            return response()->json([]); // Pas de recherche vide
        }

        $envUrl = env('ENV_URL');
        $envPort = env('ENV_PORT');

        //Appel à l'API pour récuperer tout les clients 
        $response = Http::get($envUrl . $envPort . '/toad/customer/all');

        if ($response->successful()) {
            $customers = collect($response->json());

            // Filtrage les clients sont le nom ou le prénom contient le texte saisi 
            $filteredCustomers = $customers->filter(function ($customer) use ($query) {
                return stripos($customer['first_name'], $query) !== false ||
                       stripos($customer['last_name'], $query) !== false;
            })->take(10); //ne retourne que les 10 premiers résultats 

            return response()->json($filteredCustomers->values());
        }

        return response()->json(['error' => 'Impossible de récupérer les clients.'], 500);
    }
}
