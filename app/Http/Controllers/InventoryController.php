<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class InventoryController extends Controller
{
    public function index(): View|RedirectResponse
    {
        // Appel API pour récupérer les stocks de DVD par magasin
        $response = Http::get('http://localhost:8080/toad/inventory/getStockByStore');

        if ($response->successful()) {
            $data = $response->json();

            // Simulation de la pagination
            $currentPage = request()->get('page', 1);
            $perPage = 10;
            $inventory = collect($data)->forPage($currentPage, $perPage);

            // Création d'un objet paginé
            $paginatedInventory = new \Illuminate\Pagination\LengthAwarePaginator(
                $inventory,
                count($data),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            return view('inventory', ['inventory' => $paginatedInventory]);
        } else {
            return redirect('/')->withErrors(['message' => 'Impossible de récupérer les stocks de DVD.']);
        }
    }
}
