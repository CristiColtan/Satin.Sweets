<script setup>
import { useAppStore } from '../store/index.js'
import { ref } from 'vue'
import { router } from '../router/index.js'
import Banner1 from '../components/home-page/Banner1.vue'

import Slide1 from '../assets/Slide1.png'
import ProductSection from '../components/home-page/ProductSection.vue'
import MyCarouselV2 from '../components/home-page/MyCarouselV2.vue'
import BenefitsSectionV2 from '../components/home-page/BenefitsSectionV2.vue'

const store = useAppStore()
const loading = ref(false)
function logout() {
    loading.value = true
    store
        .logout()
        .then(() => {
            loading.value = false
            router.push({ name: 'login' })
        })
        .catch(({ response }) => {
            loading.value = false
            console.log(response)
        })
}

const produse = [
    {
        img: Slide1,
        name: 'Buchetul Toamnei',
        price: '319 RON - 419 RON',
        badge: 'NOU',
    },
    {
        img: Slide1,
        name: 'Aranjament Floral Majesty',
        price: '239 RON - 339 RON',
    },
    { img: Slide1, name: 'Buchet Burgundy', price: '299 RON - 449 RON' },
]
</script>

<template>
    <div class="mx-auto mt-20 mb-20 max-w-10/12">
        <div class="flex flex-col items-center justify-center">
            <MyCarouselV2 />
            <BenefitsSectionV2 />
            <Banner1 :img="Slide1" to="/buchete-de-flori" />
            <ProductSection
                :products="produse"
                description="Alege un buchet cu flori de toamnă – culori calde, texturi inspirate din natură. Comandă flori online cu livrare în 2–4 ore."
                link="/toamna"
                title="Tablouri Cartoon"
            />
        </div>
    </div>
</template>

<style scoped></style>
