<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryController extends Controller
{
    /**
     * Construit l'URL complète pour appeler l'API.
     */
    private function buildUrl(string $endpoint): string
    {
       return env('ENV_URL') . ':' . env('ENV_PORT') . $endpoint;
    }

    
      //Affiche l'inventaire groupé par filmId avec pagination.
     
    public function index(Request $request): View|RedirectResponse
    {
        //appel de l'API pour récupérer les stocks groupés
        $envUrl = env('ENV_URL');
        $envPort = env('ENV_PORT');
        $endpointInventory ='/toad/inventory/getStockByStore';
        $data = $request->all();
        $response = Http::asForm()->get($envUrl.$envPort.$endpointInventory,$data);

        if ($response->successful()) {
            $data = $response->json();

            // Regrouper les entrés par filmId et garde uniquement les infos clé
            $groupedInventory = collect($data)
                ->groupBy('filmId')
                ->map(function ($items) {
                    return [
                        'filmId' => $items->first()['filmId'],
                        'title' => $items->first()['title'],
                        'storeId' => $items->first()['storeId'],
                        'quantity' => $items->first()['quantity'], // Compter les copies disponibles (quantité de stock pour ce film)
                    ];
                })->values();

            // Pagination
            $currentPage = $request->get('page', 1);
            $perPage = 10;
            $paginatedInventory = new LengthAwarePaginator(
                $groupedInventory->forPage($currentPage, $perPage),
                $groupedInventory->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('inventory.inventory', ['inventory' => $paginatedInventory]); //retourne la vue avec les stocks paginés
        } else {
            Log::error('Erreur API Inventaire: ' . $response->body()); //si l'appek échou, log l'erreur et redirige 
            return redirect('/films')->withErrors(['message' => 'Impossible de récupérer les stocks de DVD.']);
        }
    }

    //afficge le formulaire pour ajouter du stock dans l'inventaire, il récupère tout les films et tout les magasins
    public function create()
{
    $envUrl = env('ENV_URL');
    $envPort = env('ENV_PORT');
    
    //Appel API pour récuperer les films et les magasins 
    $responseFilms = Http::get($envUrl . $envPort . '/toad/films/getAll');
    $responseStores = Http::get($envUrl . $envPort . '/toad/stores/getAll');

    
    if ($responseFilms->successful() && $responseStores->successful()) {
        $films = $responseFilms->json();
        $stores = $responseStores->json();

        return view('inventory.create', compact('films', 'stores'));
    }//renvoie la vue avec les listes de films et de magasins pour le formulaire

    return redirect('/films')->withErrors([
        'message' => 'Impossible de récupérer les films ou les magasins.'
    ]);
}

    


/*insérer plusiseurs exemplaires d'un film dans un magasin (cette partie la ne fonctionne pas encore il 
nous manque un web service)*/
public function storeMultiple(Request $request)
{
    //validation du formulaire: sécurité + vérification de la cohérence avec la bdd)
    $request->validate([
        'film_id' => 'required|integer|exists:film,film_id',
        'store_id' => 'required|integer|exists:store,store_id',
        'quantity' => 'required|integer|min:1',
    ]);

    $filmId = $request->film_id;
    $storeId = $request->store_id;
    $quantity = $request->quantity;

    //boucle pour insérer chaque exemplaire une par une dans la table inventory

    for ($i = 0; $i < $quantity; $i++) {
        DB::table('inventory')->insert([
            'film_id' => $filmId,
            'store_id' => $storeId,
            'last_update' => Carbon::now(),
            'existe' => 1, //indique que l'exemplaire est actif /disponible 
        ]);
    }

    return redirect()->route('inventory-create')->with('success', "$quantity exemplaire(s) ajouté(s) !");
}

}