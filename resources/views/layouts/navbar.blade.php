@auth
    @if(auth()->user()->hasRole('ServiceProvider'))
        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <a href="{{ route('provider.dashboard') }}" class="{{ request()->routeIs('provider.dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Dashboard
            </a>
            <a href="{{ route('provider.statistics') }}" class="{{ request()->routeIs('provider.statistics') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Statistiques
            </a>
            <a href="{{ route('provider.settings') }}" class="{{ request()->routeIs('provider.settings') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Paramètres
            </a>
        </div>
    @endif
@endauth 