<template>
    <Swiper
        :autoplay="{ delay: 2500, disableOnInteraction: false }"
        :loop="true"
        :navigation="true"
        :pagination="{ clickable: true }"
        :slides-per-view="1"
        :space-between="30"
        class="mySwiper"
    >
        <SwiperSlide v-for="(slide, index) in slides" :key="index">
            <img
                :alt="'Slide' + (index + 1)"
                :src="slide.img"
                class="carousel-img"
            />
        </SwiperSlide>
    </Swiper>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'

import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import 'swiper/css/autoplay'
import Slide2 from '../../assets/Slide2.png'

const slides = [
    {
        img: Slide2,
    },
    {
        img: Slide2,
    },
]
</script>

<style scoped>
.mySwiper {
    width: 100%;
    margin: auto;
    border-radius: 12px;
    overflow: hidden;
}

.carousel-img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 12px;
}
</style>
