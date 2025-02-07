<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <!-- Titre et bouton -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Gestion des Stocks de DVD</h1>
            <a href="{{ route('inventory') }}" 
               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                + Ajouter un film
            </a>
        </div>

        <!-- Grille des stocks -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach ($inventory as $stock)
                <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6 flex flex-col justify-between hover:shadow-lg transition-shadow duration-300">
                    <h2 class="text-2xl font-bold mb-2 text-gray-800">
                        {{ $stock['film_title'] ?? 'Titre inconnu' }}
                    </h2>
                    
                    <p><strong>Stock ID :</strong> {{ $stock['inventory_id'] }}</p>
                    <p><strong>Film ID :</strong> {{ $stock['film_id'] }}</p>
                    <p><strong>Magasin ID :</strong> {{ $stock['store_id'] }}</p>
                    <p><strong>Dernière mise à jour :</strong> {{ $stock['last_update'] }}</p>
                </div>
            @endforeach
        </div>

        <!-- Liens de pagination -->
        <div class="mt-6">
            {{ $inventory->links() }}
        </div>
    </div>
</x-app-layout>
