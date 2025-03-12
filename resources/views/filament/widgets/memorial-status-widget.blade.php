<x-filament::section>
    <x-slot name="heading">
        Estado del Memorial
    </x-slot>
    
    <x-slot name="headerEnd">
        <div class="flex items-center">
            <span class="text-sm font-medium mr-2">Completado: {{ $this->getCompletionPercentage() }}%</span>
            <div class="h-2 w-24 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-primary-500 rounded-full" style="width: {{ $this->getCompletionPercentage() }}%"></div>
            </div>
        </div>
    </x-slot>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($this->getStatusItems() as $item)
            <div class="flex items-center p-3 rounded-lg {{ $item['status'] ? 'bg-success-50 border border-success-200' : 'bg-danger-50 border border-danger-200' }}">
                <div class="mr-3 {{ $item['status'] ? 'text-success-500' : 'text-danger-500' }}">
                    @if($item['status'])
                        @svg('heroicon-o-check-circle', 'h-6 w-6')
                    @else
                        @svg('heroicon-o-x-circle', 'h-6 w-6')
                    @endif
                </div>
                <div class="flex items-center">
                    <div class="{{ $item['status'] ? 'text-success-700' : 'text-danger-700' }} mr-2">
                        @svg($item['icon'], 'h-5 w-5')
                    </div>
                    <span class="text-sm font-medium">{{ $item['label'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
    
    @if($this->getMemorial())
        <x-slot name="footer">
            <div class="text-right">
                <a href="{{ route('filament.admin.resources.memorials.edit', $this->getMemorial()) }}" class="text-primary-600 hover:text-primary-500 text-sm font-medium">
                    Editar memorial &rarr;
                </a>
            </div>
        </x-slot>
    @endif
</x-filament::section> 