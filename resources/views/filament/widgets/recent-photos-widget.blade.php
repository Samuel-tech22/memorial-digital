<x-filament::section>
    <x-slot name="heading">
        Fotos Recientes
    </x-slot>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($this->getPhotos() as $photo)
            <div class="relative group overflow-hidden rounded-lg shadow-md">
                <img 
                    src="{{ $photo->url ? (str_starts_with($photo->url, 'memoriales/') ? Storage::url($photo->url) : asset('storage/' . $photo->url)) : asset('images/placeholder.jpg') }}" 
                    alt="{{ $photo->titulo ?? 'Sin título' }}" 
                    class="h-32 w-full object-cover transition-all duration-300 group-hover:scale-110"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-2">
                    <h3 class="text-white text-xs truncate">{{ $photo->titulo ?? 'Sin título' }}</h3>
                </div>
            </div>
        @endforeach
    </div>
    
    @if(count($this->getPhotos()) === 0)
        <div class="flex justify-center items-center p-6 text-gray-500">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium">No hay fotos disponibles</h3>
                <p class="mt-1 text-sm">Sube algunas fotos para empezar.</p>
            </div>
        </div>
    @endif
    
    <x-slot name="footer">
        <div class="text-right">
            <a href="{{ route('filament.admin.resources.fotos.index') }}" class="text-primary-600 hover:text-primary-500 text-sm font-medium">
                Ver todas las fotos &rarr;
            </a>
        </div>
    </x-slot>
</x-filament::section> 