<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <h1 class="text-3xl font-bold mb-6">{{ $film['title'] }}</h1>
        <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6">
            <p><strong>Description :</strong> {{ $film['description'] ?? 'Non disponible' }}</p>
            <p><strong>Année de sortie :</strong> {{ $film['release_year'] ?? 'Non disponible' }}</p>
            <p><strong>Durée de location :</strong> {{ $film['rental_duration'] ?? 'Non disponible' }} jours</p>
            <p><strong>Dernière mise à jour :</strong> {{ $film['last_update'] ?? 'Non disponible' }}</p>
        </div>

        <div class="mt-4 flex space-x-4">
            <a href="{{ route('films') }}" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-200">
                Retour au catalogue
            </a>
            
            <!-- Bouton Modifier -->
            <a href="{{ route('film.edit', ['filmId' => $film['filmId']]) }}" class="bg-yellow-500 text-black px-4 py-2 rounded hover:bg-yellow-600 transition-colors duration-200">
                Modifier
            </a>

            <!-- Bouton Supprimer -->
            <form action="{{ route('film.destroy', ['filmId' => $film['filmId']]) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce film ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-black px-4 py-2 rounded hover:bg-red-600 transition-colors duration-200">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
