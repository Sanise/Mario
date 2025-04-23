<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <!-- Titre principal de la page -->
        <h1 class="text-3xl font-bold mb-6">DVD Réservés</h1>

        <!-- Champ de recherche de client avec suggestion automatique -->
        <input type="text" id="customerSearch" placeholder="Rechercher un client..." class="border p-2 w-full">
        <ul id="searchResults" class="bg-white border mt-2 w-full"></ul>

        <!-- Liste affichée de tous les clients avec lien vers leurs locations -->
        @foreach ($customers as $customer)
            <div class="mb-6 border-b pb-4">
                <!-- Lien cliquable vers les locations du client -->
                <a href="{{ route('rentals.index', ['customerId' => $customer['customerId']]) }}"
                   class="text-xl font-semibold text-blue-600 hover:underline">
                    {{ $customer['firstName'] }} {{ $customer['lastName'] }}
                </a>
                <!-- Détails visibles -->
                <p>Email : {{ $customer['email'] }}</p>
                <p>Client ID : {{ $customer['customerId'] }}</p>
            </div>
        @endforeach

        <!-- Si un client a été sélectionné, on affiche ses films loués -->
        @if ($selectedCustomer)
            <hr class="my-8">
            <h2 class="text-2xl font-bold mb-2">
                Films loués par {{ $selectedCustomer['firstName'] }} {{ $selectedCustomer['lastName'] }}
            </h2>
            <p>Email : {{ $selectedCustomer['email'] }}</p>
            <p>Client ID : {{ $selectedCustomer['customerId'] }}</p>

            <!-- Tableau récapitulatif des locations du client -->
            <table class="table-auto w-full border mt-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Film</th>
                        <th class="border px-4 py-2">Date de Location</th>
                        <th class="border px-4 py-2">Date de Retour</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rentals as $rental)
                        <tr>
                            <td class="border px-4 py-2">{{ $rental['title'] }}</td>
                            <td class="border px-4 py-2">{{ $rental['rental_date'] }}</td>
                            <td class="border px-4 py-2">
                                {{ $rental['return_date'] ?? 'Pas encore retourné' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border px-4 py-2 text-center text-gray-500">
                                Aucun film loué.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        <!-- Script JavaScript AJAX pour la recherche de clients en temps réel -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                // Détection de saisie dans le champ client
                $('#customerSearch').on('keyup', function () {
                    let query = $(this).val();
                    if (query.length > 1) {
                        // Appel AJAX vers la route de recherche de clients
                        $.ajax({
                            url: "{{ route('customers.search') }}",
                            type: 'GET',
                            // Affichage des résultats clients trouvés
                            data: { query: query },
                            success: function (data) {
                                $('#searchResults').empty();
                                if (data.length > 0) {
                                    data.forEach(function (customer) {
                                        $('#searchResults').append(`
                                            <li class="p-2 cursor-pointer hover:bg-gray-200"
                                                data-id="${customer.customerId}">
                                                ${customer.firstName} ${customer.lastName}
                                            </li>`);
                                    });
                                } else {
                                    $('#searchResults').append('<li class="p-2 text-gray-500">Aucun résultat</li>');
                                }
                            }
                        });
                    } else {
                        $('#searchResults').empty();
                    }
                });

                // Cliquer sur un nom de la liste pour naviguer vers ses locations
                $(document).on('click', '#searchResults li', function () {
                    let customerId = $(this).data('id');
                    window.location.href = "/rentals?customerId=" + customerId; // Recharge avec client sélectionné
                });
            });
        </script>
    </div>
</x-app-layout>
