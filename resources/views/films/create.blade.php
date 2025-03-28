<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <h1 class="text-3xl font-bold mb-6">Ajouter un nouveau film</h1>

        <form action="{{ route('film.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="title" class="block font-bold">Titre :</label>
                <input type="text" name="title" id="title" required class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label for="description" class="block font-bold">Description :</label>
                <textarea name="description" id="description" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="mb-4">
                <label for="release_year" class="block font-bold">Année de sortie :</label>
                <input type="number" name="release_year" id="release_year" required class="w-full border rounded p-2">
            </div>

            <!-- Champ rating -->
            <div class="form-group mb-6 text-center">
                <label for="rating" class="block text-lg font-medium text-gray-700">Note</label>
                <select name="rating" id="rating" required
                    class="mt-2 block w-full max-w-2xl px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 mx-auto">
                    <option value="G" {{ old('rating') == 'G' ? 'selected' : '' }}>G</option>
                    <option value="PG" {{ old('rating') == 'PG' ? 'selected' : '' }}>PG</option>
                    <option value="PG-13" {{ old('rating') == 'PG-13' ? 'selected' : '' }}>PG-13</option>
                    <option value="R" {{ old('rating') == 'R' ? 'selected' : '' }}>R</option>
                    <option value="NC-17" {{ old('rating') == 'NC-17' ? 'selected' : '' }}>NC-17</option>
                </select>
            </div>

            <!-- Champ rentalDuration -->
            <div class="form-group mb-6 text-center">
                <label for="rental_duration" class="block text-lg font-medium text-gray-700">Durée de location</label>
                <input type="number" name="rental_duration" id="rental_duration" value="{{ old('rental_duration') }}" required
                    class="mt-2 block w-full max-w-2xl px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 mx-auto">
            </div>

            <!-- Champ length -->
            <div class="form-group mb-6 text-center">
                <label for="length" class="block text-lg font-medium text-gray-700">Durée (en minutes)</label>
                <input type="number" name="length" id="length" value="{{ old('length') }}" required
                    class="mt-2 block w-full max-w-2xl px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 mx-auto">
            </div>

            <input type="hidden" name="language_id" value="{{ old('language_id', 1) }}">
            <input type="hidden" name="original_language_id" value="{{ old('original_language_id', 1) }}">
            <input type="hidden" name="rental_rate" value="{{ old('rental_rate', 4.99) }}">
            <input type="hidden" name="replacement_cost" value="{{ old('replacement_cost', 19.99) }}">
            <input type="hidden" name="lastUpdate" id="lastUpdate">

            <script>
                // Générer automatiquement la date actuelle au format YYYY-MM-DD HH:MM:SS pour la mise à jour
                document.addEventListener("DOMContentLoaded", function () {
                    let now = new Date();
                    let formattedDate = now.getFullYear() + "-" +
                        ("0" + (now.getMonth() + 1)).slice(-2) + "-" +
                        ("0" + now.getDate()).slice(-2) + " " +
                        ("0" + now.getHours()).slice(-2) + ":" +
                        ("0" + now.getMinutes()).slice(-2) + ":" +
                        ("0" + now.getSeconds()).slice(-2);

                    document.getElementById("lastUpdate").value = formattedDate;
                });
            </script>

            <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600">
                Ajouter
            </button>
        </form>
    </div>
</x-app-layout>
