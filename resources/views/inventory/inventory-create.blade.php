<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ajouter un DVD dans le stock
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('inventory.store') }}" onsubmit="ajouterDate()">
                        @csrf

                        <div class="mb-4">
                            <label for="film_id" class="block text-sm font-medium">Choisir un film</label>
                            <select name="film_id" id="film_id" required
                                class="mt-2 block w-full max-w-2xl px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mx-auto">
                                <option value="">--Choisir un film--</option>
                                @foreach ($films as $film)
                                    <option value="{{ $film['filmId'] }}">{{ $film['title'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="store_id" class="block text-sm font-medium">ID du Magasin</label>
                            <input type="number" name="store_id" id="store_id"
                                class="mt-1 block w-full rounded-md border-gray-300"
                                placeholder="ex: 1" required>
                        </div>

                        <input type="hidden" name="LastUpdate" id="LastUpdate" />

                        <div class="flex justify-between items-center mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded">
                                Ajouter au stock
                            </button>
                            <a href="{{ route('inventory') }}" class="text-black-500 hover:underline">
                                Retour à l’inventaire
                            </a>
                        </div>
                    </form>

                </div>
                <div class="my-20 py-10 border-t-2 border-gray-400"></div>


                
            </div>
            <div class="mb-4">
                            <label for="film_id" class="block text-sm font-medium">Choisir un film</label>
                            <select name="film_id" id="film_id" required
                                class="mt-2 block w-full max-w-2xl px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mx-auto">
                                <option value="">--Choisir un film--</option>
                                @foreach ($films as $film)
                                    <option value="{{ $film['filmId'] }}">{{ $film['title'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="store_id" class="block text-sm font-medium">ID du Magasin</label>
                            <input type="number" name="store_id" id="store_id"
                                class="mt-1 block w-full rounded-md border-gray-300"
                                placeholder="ex: 1" required>
                        </div>

                        <input type="hidden" name="LastUpdate" id="LastUpdate" />

                        <div class="flex justify-between items-center mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded">
                                Supprimer du stock
                            </button>
                            <a href="{{ route('inventory') }}" class="text-black-500 hover:underline">
                                Retour à l’inventaire
                            </a>
                        </div>
                    </form>

                </div>
        </div>
    </div>

    <script>
        function ajouterDate() {
            const now = new Date();
            const dateFormatted = now.getFullYear() + "-"
                + String(now.getMonth() + 1).padStart(2, '0') + "-"
                + String(now.getDate()).padStart(2, '0') + " "
                + String(now.getHours()).padStart(2, '0') + ":"
                + String(now.getMinutes()).padStart(2, '0') + ":"
                + String(now.getSeconds()).padStart(2, '0');
            document.getElementById('LastUpdate').value = dateFormatted;
        }
    </script>
</x-app-layout>
