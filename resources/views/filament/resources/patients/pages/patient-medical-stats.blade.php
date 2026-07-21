<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
        @foreach($this->getStats() as $stat)
            {{ $stat }}
        @endforeach
    </div>

    <div class="mt-6">
        {{ $this->table }}
    </div>
</x-filament-panels::page>