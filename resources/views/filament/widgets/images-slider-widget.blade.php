<x-filament-widgets::widget>
    <div style="position: relative; width: 100%; height: 320px; overflow: hidden; border-radius: 0.75rem;">
        <!-- Alpine slider -->
      <div
    x-data="{
        slides: {{ Js::from($this->getImages()) }},
        index: 0,
        duration: 4500,
        timer: null,
        start() {
            this.index = 0
            this.timer = setInterval(() => {
                this.index = (this.index + 1) % this.slides.length
            }, this.duration)
        },
        stop() {
            clearInterval(this.timer)
        }
    }"
    x-init="start()"
    x-on:mouseenter="stop()"
    x-on:mouseleave="start()"
    class="w-full h-full relative"
>
    <template x-for="(slide, i) in slides" :key="i">
    <div
        style="height: 330px; width: 100%;"
        x-show="index === i"
        x-transition.opacity.duration.800ms
        class="absolute inset-0 bg-cover bg-center flex items-end"
        :style="`background-image: url(${slide.src}); height: 330px; width: 100%;`"
    >
        <div class="w-full bg-black/40 text-white p-4 text-center">
            <span x-text="slide.caption"></span>
        </div>
    </div>
</template>



</div>



    </div>
</x-filament-widgets::widget>
