<x-filament-widgets::widget>
    <div x-data
        x-on:refreshStats.window="$wire.$refresh()"

        style="position: relative; width: 100%; height: 330px; overflow: hidden; border-radius: 0.75rem;">


        <!-- ضمن الـ widget view لديك -->



        <div
            x-data="{
                slides: {{ Js::from($this->getRecords()) }},
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
            class="w-full h-full relative">
            <template x-for="(slide, i) in slides" :key="i">

                <div
                    x-show="index === i"
                    x-transition.opacity.duration.800ms
                    class="absolute inset-0 flex items-end justify-center"
                    style="height: 330px; width: 100%;">

                    <img
                        :src="slide.src"
                        alt=""
                        class="w-full h-full object-cover rounded"
                        style="height: 330px; width: 100%;">
                    <h1 class="absolute bottom-0 w-full bg-black text-white text-center py-1 text-sm ">
                        <span x-text="slide.caption"></span>
                    </h1>
                </div>

            </template>

        </div>
    </div>
</x-filament-widgets::widget>
