<x-app-layout> 
    <!-- Layout principal de l'application (entête + contenu) -->
    
    <!-- Grille responsive pour afficher les stocks -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($inventory as $stock)
            <!-- Carte décorative pour chaque stock de film -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                
                <!-- Titre du film ou "Titre inconnu" si absent -->
                <h2 class="text-xl font-bold mb-2 text-gray-800">
                    {{ $stock['title'] ?? 'Titre inconnu' }}
                </h2>

                <!-- Identifiant du magasin où le stock est disponible -->
                <p class="text-gray-700"><strong>Magasin :</strong> {{ $stock['storeId'] ?? 'Inconnu' }}</p>

                <!-- Quantité d'exemplaires disponibles -->
                <p class="text-gray-700"><strong>Quantité disponible :</strong> {{ $stock['quantity'] ?? 0 }}</p>

                <!-- Bouton Supprimer -->
                <form action="{{ route('inventory.destroy', $stock['filmId']) }}" method="POST" class="mt-4 inline-block" onsubmit="return confirm('Voulez-vous vraiment supprimer ce stock ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-mario-red text-black py-1 px-3 rounded hover:bg-red-700 transition-colors">
                        Supprimer
                    </button>
                </form>
            </div>
        @empty
            <!-- Si aucun stock n'est disponible, on affiche un message -->
            <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                <p class="text-gray-500">Aucun stock trouvé.</p>
            </div>
        @endforelse
    </div>

    <!-- Bloc pour la pagination des stocks -->
    <div class="mt-6">
        {{ $inventory->links() }}  <!-- Gère les boutons de pagination -->
    </div>
</x-app-layout>
