<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <h1 class="text-3xl font-bold mb-6">Modifier le film</h1>
        
        <form action="{{ route('film.update', ['filmId' => $film['filmId'] ?? '']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block font-bold">Titre :</label>
                <input type="text" name="title" id="title" 
                       value="{{ $film['title'] ?? '' }}" 
                       class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label for="description" class="block font-bold">Description :</label>
                <textarea name="description" id="description" class="w-full border rounded p-2">
                    {{ $film['description'] ?? '' }}
                </textarea>
            </div>

            <div class="mb-4">
                <label for="release_year" class="block font-bold">Année de sortie :</label>
                <input type="number" name="release_year" id="release_year" 
                       value="{{ $film['release_year'] ?? '' }}" 
                       class="w-full border rounded p-2">
            </div> 

            <div class="mb-4">
                <label for="rental_duration" class="block font-bold">Durée de location (jours) :</label>
                <input type="number" name="rental_duration" id="rental_duration" 
                       value="{{ $film['rental_duration'] ?? '' }}" 
                       class="w-full border rounded p-2">
            </div>

            <button type="submit" class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600">
                Mettre à jour
            </button>
        </form>
    </div>
</x-app-layout>
