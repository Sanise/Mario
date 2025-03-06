<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Film;
use Illuminate\Http\Request;


class FilmController extends Controller
{
   
    public function index(): View|RedirectResponse
    {
        $response = Http::get('http://localhost:8080/toad/film/all');

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

    
    public function details(): View|RedirectResponse
    {
        $filmId = request()->get('filmId');

        if (!$filmId) {
            return redirect()->route('films')
                ->withErrors(['message' => 'Aucun film spécifié.']);
        }

        $response = Http::get("http://localhost:8080/toad/film/getById", [
            'id' => $filmId
        ]);

        if ($response->successful()) {
            $film = $response->json();
            return view('films.details', ['film' => $film]);
        }

        return redirect()->route('films')
            ->withErrors(['message' => 'Impossible de récupérer le film.']);
    }

    public function edit($filmId): View|RedirectResponse //récupére un film depuis l’API et afficher un formulaire d’édition.
    {
        $response = Http::get("http://localhost:8080/toad/film/getById", [
            'id' => $filmId
        ]);

        if ($response->successful()) {
            $film = $response->json();
         //   dd($film);
            return view('films.edit', ['film' => $film]);
        }

        return redirect()->route('films')
            ->withErrors(['message' => 'Impossible de récupérer le film.']);
    }

    public function destroy($filmId): RedirectResponse
    {
        $response = Http::delete("http://localhost:8080/toad/film/delete", [
            'id' => $filmId
        ]);

        if ($response->successful()) {
            return redirect()->route('films')->with('success', 'Film supprimé avec succès.');
        }

        return back()->withErrors(['message' => 'Impossible de supprimer le film.']);
    }
    public function update(Request $request, $filmId): RedirectResponse //Enregistre les modifications dans la bdd
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'release_year' => 'required|integer',
        'rental_duration' => 'required|integer'
    ]);

    $response = Http::put("http://localhost:8080/toad/film/update", array_merge(['id' => $filmId], $validatedData));

    if ($response->successful()) {
        return redirect()->route('films')->with('success', 'Film mis à jour avec succès.');
    }

    return back()->withErrors(['message' => 'Échec de la mise à jour du film.']);
}
public function create(): View
{
    return view('films.create');
}
public function store(Request $request): RedirectResponse
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'release_year' => 'required|integer',
        'rental_duration' => 'required|integer'
    ]);

    $response = Http::post("http://localhost:8080/toad/film/create", $validatedData);

    if ($response->successful()) {
        return redirect()->route('films')->with('success', 'Film ajouté avec succès.');
    }

    return back()->withErrors(['message' => 'Échec de l\'ajout du film.']);
}



}
