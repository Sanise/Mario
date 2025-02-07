<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <h1 class="text-3xl font-bold mb-6">DVD Réservés</h1>
        <input type="text" id="customerSearch" placeholder="Rechercher un client..." class="border p-2 w-full">
        <ul id="searchResults" class="bg-white border mt-2 w-full"></ul>

        @foreach ($customers as $customer)
            <div class="mb-6">
                <h2 class="text-2xl font-bold">{{ $customer->first_name }} {{ $customer->last_name }}</h2>
                <p>Email : {{ $customer->email }}</p> <!-- Correction "email" → "emaii" -->
                <p>Client ID : {{ $customer->customer_id }}</p>

                <!-- Liste des films loués -->
                <table class="table-auto w-full border-collapse border border-gray-300 mt-4">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Film</th>
                            <th class="border border-gray-300 px-4 py-2">Date de Location</th>
                            <th class="border border-gray-300 px-4 py-2">Date de Retour</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customer->rentals as $rental)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $rental->inventory->film->title ?? 'Film non trouvé' }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ $rental->rental_date }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $rental->return_date ?? 'Pas encore retourné' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border border-gray-300 px-4 py-2 text-center">
                                    Aucun film loué.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="mt-6">
            {{ $customers->links() }}
        </div>

        <!-- Script AJAX pour la Recherche -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#customerSearch').on('keyup', function() {
                    let query = $(this).val();
                    if (query.length > 1) {
                        $.ajax({
                            url: "{{ route('customers.search') }}",
                            type: 'GET',
                            data: { query: query },
                            success: function(data) {
                                $('#searchResults').empty();
                                if (data.length > 0) {
                                    data.forEach(function(customer) {
                                        $('#searchResults').append(`<li class="p-2 cursor-pointer hover:bg-gray-200" data-id="${customer.customer_id}">${customer.first_name} ${customer.last_name}</li>`);
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

                $(document).on('click', '#searchResults li', function() {
                    let customerId = $(this).data('id');
                    window.location.href = "/rentals?customerId=" + customerId;
                });
            });
        </script>
    </div>
</x-app-layout>
