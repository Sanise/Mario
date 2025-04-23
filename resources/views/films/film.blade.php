<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <!-- En-tête de la page avec titre et bouton d'ajout -->
        <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Catalogue de Films</h1>
    <!-- Lien vers le formulaire d'ajout d'un nouveau film -->
    <a href="{{ route('film.create') }}" 
       class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600 transition">
        + Ajouter un film
    </a>
</div>

<!-- Grille responsive des cartes de films  -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach ($films as $film)
            <!-- Carte individuelle pour chaque film -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6 flex flex-col justify-between hover:shadow-lg transition-shadow duration-300">
                    <!-- Titre du film affiché en gras -->
                    <h2 class="text-2xl font-bold mb-2 text-gray-800">{{ $film['title'] }}</h2>
              <!--    Bouton qui redirige vers la page de détails du film
                    <details>
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
        <!-- Pagination automatique générée par Laravel -->
        <div class="mt-6">
            {{ $films->links() }}
        </div>
    </div>
</x-app-layout>
