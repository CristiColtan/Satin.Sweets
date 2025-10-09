<template>
    <div class="relative mx-auto w-full overflow-hidden rounded-lg">
        <div
            :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
            class="flex transition-transform duration-700"
        >
            <div
                v-for="(slide, i) in slides"
                :key="i"
                class="w-full flex-shrink-0"
            >
                <img
                    :src="slide.img"
                    alt="slide"
                    class="h-144 w-full object-cover"
                />
            </div>
        </div>

        <button
            class="absolute top-1/2 left-2 -translate-y-1/2 rounded bg-black/50 px-2 py-1 text-white"
            @click="prevSlide"
        >
            ❮
        </button>
        <button
            class="absolute top-1/2 right-2 -translate-y-1/2 rounded bg-black/50 px-2 py-1 text-white"
            @click="nextSlide"
        >
            ❯
        </button>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, ref } from 'vue'

import Slide2 from '../../assets/Slide2.png'
import Slide1 from '../../assets/Slide1.png'

const slides = [
    {
        img: Slide1,
        text: 'Tablouri Cartoon!',
    },
    {
        img: Slide2,
        text: 'Buchete din satin!',
    },
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
    intervalId = setInterval(nextSlide, 10000) // schimbă slide la fiecare 3 secunde
})

onUnmounted(() => {
    clearInterval(intervalId)
})
</script>
