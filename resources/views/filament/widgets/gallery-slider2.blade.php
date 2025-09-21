
<x-filament-widgets::widget>
    <div style="position: relative; width: 100%; height: 180px; overflow: hidden; border-radius: 0.75rem; background: #000;">
        <div
            x-data="{ slides: {{ Js::from($this->getRecords()) }} }"
            class="absolute top-0 left-0 flex gap-6 animate-marquee"
            style="height: 100%;"
        >
            <template x-for="(slide, i) in slides" :key="i">
                <div class="flex-shrink-0 relative" style="height: 100%; width: 280px;">
                    <img :src="slide.src" :alt="slide.caption"
                         class="h-full w-full object-cover rounded-xl shadow-lg" />
                    <div class="absolute bottom-0 w-full bg-black/50 text-white text-center py-1 text-sm">
                        <span x-text="slide.caption"></span>
                    </div>
                </div>
            </template>

            {{-- نكرر نفس الصور تاني عشان الحركة تبان مستمرة --}}
            <template x-for="(slide, i) in slides" :key="'clone-' + i">
                <div class="flex-shrink-0 relative" style="height: 100%; width: 280px;">
                    <img :src="slide.src" :alt="slide.caption"
                         class="h-full w-full object-cover rounded-xl shadow-lg" />
                    <div class="absolute bottom-0 w-full bg-black/50 text-white text-center py-1 text-sm">
                        <span x-text="slide.caption"></span>
                    </div>
                </div>
            </template>


        </div>
    </div>

    {{-- ستايل الأنيميشن --}}
    <style>
        @keyframes marquee {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-70%); }
        }
        .animate-marquee {
            display: flex;
            width: max-content;
            animation: marquee 30s linear infinite;
        }
    </style>
</x-filament-widgets::widget>
