<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
     <!-- Chargement de Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <!-- Conteneur principal centré verticalement et horizontalement -->
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
         <!-- Titre du formulaire -->
        <h2 class="text-2xl font-semibold text-center mb-6">Connexion</h2>

        <!-- Affichage d'un message d'erreur en cas d'échec de connexion -->
        @if(session('error'))
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Affichage d'un message de succès (par exemple après déconnexion) -->
        @if(session('success'))
            <div class="bg-green-100 text-green-600 p-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire de connexion -->
        <form action="{{ route('login_staff') }}" method="POST">
            @csrf <!-- Jeton CSRF pour la sécurité du formulaire -->

             <!-- Champ email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                       <!-- Affiche une erreur si la validation Laravel échoue sur le champ email -->
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium">Mot de passe</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton de soumission du formulaire -->
            <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                Se connecter
            </button>
        </form>
    </div>
</body>
</html>
 