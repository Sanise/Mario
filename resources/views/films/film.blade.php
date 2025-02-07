<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <!-- Grille de films en deux colonnes -->
        <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Catalogue de Films</h1>
    <a href="{{ route('film.create') }}" 
       class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600 transition">
        + Ajouter un film
    </a>
</div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach ($films as $film)
                <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6 flex flex-col justify-between hover:shadow-lg transition-shadow duration-300">
                    <h2 class="text-2xl font-bold mb-2 text-gray-800">{{ $film['title'] }}</h2>
              <!--      <details>
                        <summary>En savoir plus</summary>
                        <br>
                        <p class="text-gray-700 mb-4">{{ Str::limit($film['description'], 100) }}</p>
                    </details> -->
                    <!-- Bouton pour être redirigé vers la page des détails -->
                    <a href="{{ route('films.details', ['filmId' => $film['filmId']]) }}" class="mt-auto bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-200 text-center">
                        En savoir plus
                    </a>
                </div>
            @endforeach
        </div>
        <!-- Liens de pagination -->
        <div class="mt-6">
            {{ $films->links() }}
        </div>
    </div>
</x-app-layout>
