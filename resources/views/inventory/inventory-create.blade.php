<x-app-layout>
    <!-- Slot d'en-tête : Titre affiché en haut de la page -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ajouter un DVD dans le stock
        </h2>
    </x-slot>
 <!-- Zone principale de contenu -->
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Conteneur avec fond clair et coins arrondis -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Formulaire d'envoi POST vers la route nommée inventory.storeMultiple -->
                    <form method="POST" action="{{ route('inventory.storeMultiple') }}">
                        @csrf <!-- Jeton CSRF pour protéger contre les attaques Cross Site Request Forgery -->
                        <!-- Sélecteur de film (dropdown) -->
                        <div class="mb-4">
                            <label for="film_id" class="block text-sm font-medium">Choisir un film</label>
                            <select name="film_id" id="film_id" class="mt-1 block w-full rounded-md">
                                @foreach ($films as $film)
                                <!-- Chaque option contient l'ID du film et son titre -->
                                    <option value="{{ $film->film_id }}">{{ $film->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sélecteur de magasin (dropdown) -->
                        <div class="mb-4">
                            <label for="store_id" class="block text-sm font-medium">Point de vente</label>
                            <select name="store_id" id="store_id" class="mt-1 block w-full rounded-md">
                                @foreach ($stores as $store)
                                <!-- Affiche le nom du magasin dans le menu -->
                                    <option value="{{ $store->store_id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Champ de saisie du nombre d'exemplaires à ajouter -->
                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium">Nombre d'exemplaires à ajouter</label>
                            <input type="number" name="quantity" id="quantity" class="mt-1 block w-full rounded-md" min="1" required />
                        </div>

                        <!-- Bouton pour soumettre le formulaire -->
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Ajouter au stock
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
