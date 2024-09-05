<!-- Barre de navigation -->
<nav class="bg-gray-800">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">

            <!-- Logo ou titre de l'application -->
            <a href="{{ url('/') }}" class="text-white text-2xl font-bold">App</a>

            <!-- Menu de navigation -->
            <div class="hidden sm:flex sm:space-x-4">
                @if(auth()->check())
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('home') }}" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium">Tableau de Bord Admin</a>
                        <a href="{{ route('admin.employees.index') }}" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium">Gérer les Employés</a>
                        <a href="{{ route('admin.matches.index') }}" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium">Gérer les Matchs</a>
                        <a href="{{ route('admin.teams.index') }}" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium">Gérer les Équipes</a>
                    @elseif(auth()->user()->role === 'employee')
                        <a href="{{ route('home') }}" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium">Tableau de Bord Employé</a>
                        <a href="{{ route('employee.matches.index') }}" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium">Gérer les Matchs</a>
                        <a href="{{ route('employee.teams.index') }}" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium">Gérer les Équipes</a>
                    @endif
                @endif
            </div>

            <!-- Profil et déconnexion -->
            @auth
                <div class="relative">
                    <button id="profileMenuButton" class="text-white hover:text-gray-300 focus:outline-none">
                        Profile
                    </button>
                    <div id="profileMenu" class="absolute right-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-md shadow-lg hidden">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-white hover:bg-gray-700">Modifier votre profil</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-white hover:bg-gray-700">Déconnexion</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Script JavaScript pour gérer la liste déroulante du profil -->
<script>
    document.getElementById('profileMenuButton').addEventListener('click', function() {
        var menu = document.getElementById('profileMenu');
        menu.classList.toggle('hidden');
    });
</script>