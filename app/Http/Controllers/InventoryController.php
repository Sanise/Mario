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
use Illuminate\Support\Carbon as SupportCarbon;

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
     $endpointInventory ='/toad/film/all';
     $response = Http::asForm()->get($envUrl.$envPort.$endpointInventory);
     $films = $response->successful() ? $response ->json(): [];

    return view ('inventory.inventory-create', compact('films'));

}

    


/*insérer plusiseurs exemplaires d'un film dans un magasin (cette partie la ne fonctionne pas encore)*/
public function store(Request $request)
{
    $envUrl = env('ENV_URL');
    $envPort = env('ENV_PORT');
    $endpointInventory ='/toad/inventory/add';
    $lastUpdate = Carbon::now()->format('Y-m-d H:i:s');
    $data = $request->all();
    $data ['last_update'] = $lastUpdate;
    
    $response = Http::asForm()->post($envUrl.$envPort.$endpointInventory,$data);
    if ($response->successful()){
        return redirect()->route('inventory')->with('success', "Ajout d'\un exemplaire réalisé avec succées!");
    }else{
        return back()-> withErrors("Erreur lors de l\'ajout du DVD")->withInput();
    }

    }

    public function destroy($filmId, Request $request)
{
    $envUrl = env('ENV_URL');
    $envPort = env('ENV_PORT');
    
    $endpointInventory = "/toad/inventory/deleteDVD/$filmId";
    $fullUrl = $envUrl . $envPort . $endpointInventory;

    // Affiche l'URL pour vérification
   // dd($fullUrl);

    // Appel à l’API (sera temporairement bloqué par le dd)
    $response = Http::delete($fullUrl);

    if ($response->failed()) {
        return redirect()->route('inventory')->with('failed', "La suppression du stock a échoué.");
    }

    return redirect()->route('inventory')->with('success', "Le stock a été supprimé avec succès.");
}
    
    }