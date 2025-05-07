@forelse($services as $service)
<div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="100">
    <div class="relative">
        @if($service->photos->where('is_primary', true)->first())
            <img src="{{ asset('storage/service-photos/' . $service->photos->where('is_primary', true)->first()->filename) }}" 
                 alt="{{ $service->name }}" 
                 class="w-full h-48 object-cover">
        @else
            <img src="{{ asset('images/default-service.jpg') }}" 
                 alt="{{ $service->name }}" 
                 class="w-full h-48 object-cover">
        @endif
        @if($service->created_at && $service->created_at->diffInDays(now()) < 7)
        <span class="service-badge badge-new">Nouveau</span>
        @elseif(isset($service->reservations_count) && $service->reservations_count > 5)
        <span class="service-badge badge-popular">Populaire</span>
        @endif
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
            <div class="flex items-center text-white">
                @if($service->category)
                    @if($service->category->name == 'Doctors & Hospitals')
                <i class="fas fa-stethoscope mr-2"></i>
                    @elseif($service->category->name == 'Services juridiques')
                <i class="fas fa-gavel mr-2"></i>
                    @elseif($service->category->name == 'Beauty Salon & Spas')
                <i class="fas fa-spa mr-2"></i>
                    @elseif($service->category->name == 'Hotel')
                <i class="fas fa-hotel mr-2"></i>
                @elseif($service->category->name == 'Restaurant')
                <i class="fas fa-utensils mr-2"></i>
                @else
                <i class="fas fa-tag mr-2"></i>
                @endif
                    <span class="text-sm font-medium">{{ $service->category->name }}</span>
                @else
                    <i class="fas fa-tag mr-2"></i>
                    <span class="text-sm font-medium">Non catégorisé</span>
                @endif
            </div>
        </div>
    </div>
    <div class="p-5">
        <div class="flex justify-between items-start mb-2">
            <h3 class="text-lg font-bold">{{ $service->name }}</h3>
            <div class="flex items-center">
                <div class="stars-container">
                    <div class="stars-bg">★★★★★</div>
                    <div class="stars-fg" style="width: {{ rand(80, 98) }}%">★★★★★</div>
                </div>
                <span class="text-sm text-gray-600 ml-1">{{ number_format(rand(40, 50) / 10, 1) }}</span>
            </div>
        </div>
        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($service->description, 60) }}</p>
        <div class="flex items-center text-sm text-gray-500 mb-4">
            <i class="fas fa-map-marker-alt mr-1"></i>
            <span>{{ $service->provider->city ?? 'Paris' }}</span>
            <span class="mx-2">•</span>
            <i class="fas fa-euro-sign mr-1"></i>
            <span>{{ $service->price }}€</span>
        </div>
        <div class="flex items-center text-sm text-gray-500 mb-4">
            <i class="fas fa-calendar-check mr-1 text-green-500"></i>
            <span>Disponible aujourd'hui</span>
        </div>
        <div class="flex gap-2 mt-4">
            @auth
            <a href="{{ route('client.reserve.form', $service->id) }}" class="bg-primary-600 hover:bg-primary-700 text-white rounded-md py-2 px-4 text-sm font-medium transition-colors shadow-md hover:shadow-lg flex-grow ripple text-center">
                Réserver
            </a>
            @endauth
            @guest
            <a href="{{ route('login') }}" class="bg-primary-600 hover:bg-primary-700 text-white rounded-md py-2 px-4 text-sm font-medium transition-colors shadow-md hover:shadow-lg flex-grow ripple text-center">
                Réserver
            </a>
            @endguest
            <button class="border border-gray-300 hover:bg-gray-50 rounded-md p-2 text-gray-600 transition-colors">
                <i class="far fa-heart"></i>
            </button>
        </div>
    </div>
</div>
@empty
<div class="col-span-1 md:col-span-2 lg:col-span-3 py-12 text-center bg-white rounded-xl shadow-md">
    <div class="text-gray-400 mb-4">
        <i class="fas fa-search fa-3x"></i>
    </div>
    <h3 class="text-xl font-bold mb-2">Aucun service trouvé</h3>
    <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche ou consultez nos autres catégories.</p>
    <a href="{{ route('client.services') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white rounded-md py-2 px-6 text-sm font-medium transition-colors shadow-md hover:shadow-lg">
        Voir tous les services
    </a>
</div>
@endforelse 