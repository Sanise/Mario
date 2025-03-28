<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Film;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; 

class FilmController extends Controller
{

    public function index(Request $request): View|RedirectResponse
    {
        $envUrl = env('ENV_URL');
        $envPort = env('ENV_PORT');
        $endpointAllFilm ='/toad/film/all';
        $data = $request->all();
        $response = Http::asForm()->get($envUrl.$envPort.$endpointAllFilm,$data);

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

    public function details(Request $request): View|RedirectResponse
{
    $filmId = $request->get('filmId');

    if (!$filmId) {
        return redirect()->route('films')
            ->withErrors(['message' => 'Aucun film spécifié.']);
    }

    $envUrl = env('ENV_URL');
    $envPort = env('ENV_PORT');
    $endpoint = '/toad/film/getById';
    $data = $request->all();
    $response = Http::get($envUrl . $envPort . $endpoint, ['id' => $filmId, $data]);
   

    if ($response->successful()) {
        $film = $response->json();
        return view('films.details', ['film' => $film]);
    }

    return redirect()->route('films')
        ->withErrors(['message' => 'Impossible de récupérer le film.']);
}


public function edit(string $filmId, Request $request): View|RedirectResponse
{
    $envUrl = env('ENV_URL');
    $envPort = env('ENV_PORT');
    $endpoint = '/toad/film/getById';
    $data = $request->all();
    $response = Http::get($envUrl . $envPort . $endpoint, ['id' => $filmId, $data]);


    if ($response->successful()) {
        $film = $response->json();
        return view('films.edit', ['film' => $film]);
    }

    return redirect()->route('films')
        ->withErrors(['message' => 'Impossible de récupérer le film.']);
}

public function destroy(string $filmId, Request $request): RedirectResponse
{
    $envUrl = env('ENV_URL');
    $envPort = env('ENV_PORT');
    $endpoint = "/toad/film/delete/";
    $data = $request->all();
    $response = Http::delete($envUrl . $envPort . $endpoint.$filmId, $data);

    if ($response->successful()) {
        return redirect()->route('films')->with('success', 'Film supprimé avec succès.');
    }

    return back()->withErrors(['message' => 'Impossible de supprimer le film.']);
}


public function update(Request $request, $filmId)
{
   $envUrl = env('ENV_URL');
   $envPort = env('ENV_PORT');
   $endpointUpdateFilm ='/toad/film/update/';
   $lastUpdate = Carbon::now()->format('Y-m-d H:i:s');
   $data = $request->all();
   $data['LastUpdate'] = $lastUpdate;
   $response = Http::asForm()->put($envUrl.$envPort.$endpointUpdateFilm.$filmId, $data);
    if ($response->successful()) {
        return redirect()->route('films')->with('success', 'Film mis à jour avec succès.');
    } else {
       Log::error('Erreur lors de la mise à jour du film: ' . $response->body());
       return back()->withErrors('Erreur lors de la mise à jour du film.')->withInput();
    }
}



    public function create(): View
    {
        return view('films.create');
    }

    public function store(Request $request)
{
    $envUrl = env('ENV_URL');
    $envPort = env('ENV_PORT');
    $endpoint = '/toad/film/add';
    $data = $request->all();

    $response = Http::asForm()->post($envUrl.$envPort.$endpoint, [
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'releaseYear' => $request->input('release_year'),
        'languageId' => $request->input('language_id'),
        'originalLanguageId' => $request->input('original_language_id'),
        'rentalDuration' => $request->input('rental_duration'),
        'rentalRate' => $request->input('rental_rate'),
        'length' => $request->input('length'),
        'replacementCost' => $request->input('replacement_cost'),
        'rating' => $request->input('rating'),
        'lastUpdate' => $request->input('lastUpdate'),
    ]);
    

    if ($response->successful()) {
        return redirect()->route('films')->with('success', 'Film ajouté avec succès.');
    }

    return back()->withErrors(['message' => 'Échec de l\'ajout du film.']);
}

}
