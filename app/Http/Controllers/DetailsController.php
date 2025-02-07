<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailsController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $response = Http::get('http://localhost:8080/toad/inventory/getStockByStore');

        if ($response->successful()) {
            $data = $response->json();
            
            $currentPage = request()->get('page', 1);
            $perPage = 10;
            $films = collect($data)->forPage($currentPage, $perPage);

            $paginatedFilms = new \Illuminate\Pagination\LengthAwarePaginator(
                $films,
                count($data),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            return view('films.film', ['films' => $paginatedFilms]);
        } else {
            return redirect('/')->withErrors(['message' => 'Impossible de récupérer les films.']);
        }
    }
}