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
        $url = env('ENV_URL').':'.env('ENV_PORT').'/toad/inventory/getStockByStore';
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            // Regrouper par filmId et compter les stocks
            $groupedInventory = collect($data)
                ->groupBy('filmId')
                ->map(function ($items) {
                    return [
                        'filmId' => $items->first()['filmId'],
                        'title' => $items->first()['title'],
                        'storeId' => $items->first()['storeId'],
                  //      'quantity' => $items->count(), 
                    ];
                })->values();

            // Pagination des résultats
            $currentPage = request()->get('page', 1);
            $perPage = 10;
            $paginatedInventory = new \Illuminate\Pagination\LengthAwarePaginator(
                $groupedInventory->forPage($currentPage, $perPage),
                $groupedInventory->count(),
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
