<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <!-- Titre de la page -->
        <h1 class="text-3xl font-bold mb-6">Modifier le film</h1>
        
        <!-- Formulaire de mise à jour du film existant -->
        <form action="{{ route('film.update', ['filmId' => $film['filmId'] ?? '']) }}" method="POST">
            @csrf <!-- Jeton de sécurité contre les attaques CSRF -->
            @method('PUT') <!-- Spécifie que la méthode HTTP doit être traitée comme un PUT -->

            <!-- Champ : Titre du film -->
            <div class="mb-4">
                <label for="title" class="block font-bold">Titre :</label>
                <input type="text" name="title" id="title" 
                       value="{{ $film['title'] ?? '' }}" 
                       class="w-full border rounded p-2">
            </div>

            <!-- Champ : Description du film -->
            <div class="mb-4">
                <label for="description" class="block font-bold">Description :</label>
                <textarea name="description" id="description" class="w-full border rounded p-2">
                    {{ $film['description'] ?? '' }}
                </textarea>
            </div>

            <!-- Champ : Taux de location du film (ex : 4.99 €) -->
            <div class="mb-4">
                <label for="rentalRate" class="block">Taux de location</label>
                <input type="number" name="rentalRate" id="rentalRate" value="{{ old('rentalRate', $film['rentalRate']) }}" class="border p-2 w-full" required>
            </div>

            <!-- Champ : Durée du film (en minutes) -->
            <div class="mb-4">
                <label for="length" class="block">Longueur</label>
                <input type="number" name="length" id="length" value="{{ old('length', $film['length']) }}" class="border p-2 w-full" required>
            </div>

            <!-- Champ : Coût de remplacement du DVD -->
            <div class="mb-4">
                <label for="replacementCost" class="block">Coût de remplacement</label>
                <input type="number" name="replacementCost" id="replacementCost" value="{{ old('replacementCost', $film['replacementCost']) }}" class="border p-2 w-full" required>
            </div>

            <!-- Champ : Classification du film (rating) -->
            <div class="mb-4">
                <label for="rating" class="block">Note</label>
                <select name="rating" id="rating" class="border p-2 w-full">
                    <option value="G" {{ old('rating', $film['rating']) == 'G' ? 'selected' : '' }}>G</option>
                    <option value="PG" {{ old('rating', $film['rating']) == 'PG' ? 'selected' : '' }}>PG</option>
                    <option value="PG-13" {{ old('rating', $film['rating']) == 'PG-13' ? 'selected' : '' }}>PG-13</option>
                    <option value="R" {{ old('rating', $film['rating']) == 'R' ? 'selected' : '' }}>R</option>
                    <option value="NC-17" {{ old('rating', $film['rating']) == 'NC-17' ? 'selected' : '' }}>NC-17</option>
                </select>
            </div>
 

            <!-- Champ : Année de sortie du film -->
            <label for="releaseYear" class="block font-bold">Année de sortie :</label>
            <input type="number" name="releaseYear" id="releaseYear"
              value="{{ old('releaseYear', $film['releaseYear'] ?? 2000) }}" 
              class="w-full border rounded p-2" required>

              <!-- Champ : Durée de location (en jours) -->
              <label for="rentalDuration" class="block font-bold">Durée de location (jours) :</label>
              <input type="number" name="rentalDuration" id="rentalDuration" 
              value="{{ old('rentalDuration', $film['rentalDuration'] ?? 5) }}" 
              class="w-full border rounded p-2" required>

              <!-- Champs cachés : données techniques conservées ou modifiables indirectement -->
              <input type="hidden" name="languageId" value="{{ old('languageId', $film['languageId']) }}">
              <input type="hidden" name="originalLanguageId" value="{{ old('originalLanguageId', $film['originalLanguageId']) }}">
              <input type="hidden" name="lastUpdate" id="lastUpdate" value="{{ now()->format('Y-m-d H:i:s') }}">

              <!-- Bouton pour soumettre le formulaire de mise à jour -->
            <button type="submit" class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600">
                Mettre à jour
            </button>
        </form>
    </div>
</x-app-layout>
