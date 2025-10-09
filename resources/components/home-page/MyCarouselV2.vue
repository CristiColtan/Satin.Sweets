<template>
    <section class="mx-auto w-full">
        <div class="bg-muted relative overflow-hidden rounded-2xl">
            <div
                :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
                class="flex transition-transform duration-700 ease-in-out"
            >
                <div
                    v-for="(slide, i) in slides"
                    :key="i"
                    class="relative w-full flex-shrink-0"
                >
                    <img
                        :alt="slide.text"
                        :src="slide.img"
                        class="h-[600px] w-full object-cover"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"
                    ></div>
                    <div
                        class="absolute right-0 bottom-0 left-0 p-8 text-white"
                    >
                        <span class="font-serif text-3xl font-bold sm:text-4xl">
                            {{ slide.text }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- BUTON STÂNGA -->
            <button
                aria-label="Imaginea anterioară"
                class="text-foreground absolute top-1/2 left-4 -translate-y-1/2 bg-white/90 shadow-lg backdrop-blur-sm transition-all hover:scale-110 hover:bg-white"
                style="
                    width: 48px;
                    height: 48px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                "
                @click="prevSlide"
            >
                <ChevronLeft class="h-6 w-6" />
            </button>

            <!-- BUTON DREAPTA -->
            <button
                aria-label="Imaginea următoare"
                class="text-foreground absolute top-1/2 right-4 -translate-y-1/2 bg-white/90 shadow-lg backdrop-blur-sm transition-all hover:scale-110 hover:bg-white"
                style="
                    width: 48px;
                    height: 48px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                "
                @click="nextSlide"
            >
                <ChevronRight class="h-6 w-6" />
            </button>

            <!-- INDICATORI -->
            <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-2">
                <button
                    v-for="(_, index) in slides"
                    :key="'dot-' + index"
                    :aria-label="`Mergi la imaginea ${index + 1}`"
                    :class="[
                        'transition-all duration-300',
                        index === currentIndex
                            ? 'bg-white'
                            : 'bg-white/50 hover:bg-white/75',
                    ]"
                    :style="{
                        width: index === currentIndex ? '32px' : '12px',
                        height: '12px',
                        borderRadius: index === currentIndex ? '9999px' : '50%',
                    }"
                    @click="currentIndex = index"
                />
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, onUnmounted, ref } from 'vue'
import { ChevronLeft, ChevronRight } from 'lucide-vue-next'

import Slide1 from '../../assets/Slide1.png'
import Slide2 from '../../assets/Slide2.png'

const slides = [
    { img: Slide1, text: 'Tablouri Cartoon!' },
    { img: Slide2, text: 'Buchete din satin!' },
]

const currentIndex = ref(0)
let intervalId = null

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % slides.length
}
const prevSlide = () => {
    currentIndex.value =
        (currentIndex.value - 1 + slides.length) % slides.length
}

onMounted(() => {
    intervalId = setInterval(nextSlide, 5000) // auto-slide la 5 secunde
})

onUnmounted(() => {
    clearInterval(intervalId)
})
</script>

<style scoped></style>
