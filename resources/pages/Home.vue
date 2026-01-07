<script setup>
import { useAppStore } from '../store/index.js'
import { onMounted, ref } from 'vue'
import { router } from '../router/index.js'
import { useFieldErrors } from '../utils/useFieldErrors.js'
import axiosClient from '../js/axios.js'
import Subscribe from '../components/home-page/Subscribe.vue'
import MyCarouselV2 from '../components/home-page/MyCarouselV2.vue'
import BenefitsSectionV2 from '../components/home-page/BenefitsSectionV2.vue'
import Banner1 from '../components/home-page/Banner1.vue'
import ProductSectionType1 from '../components/home-page/ProductSectionType1.vue'
import ProductSectionType2 from '../components/home-page/ProductSectionType2.vue'

import Slide1 from '../assets/Slide1.png'

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

const { formErrors, generalError, handleApiError } = useFieldErrors()
async function fetchCartoons(cartoons) {
    generalError.value = null

    try {
        const cart = await axiosClient.get(`/products?category_id=8`)
        cartoons.value = cart.data.data
    } catch (err) {
        console.log('Eroare fetch cartoons: ', err)
        handleApiError(err)
    }
}

async function fetchCategories(categories) {
    generalError.value = null
    let cats

    try {
        cats = await axiosClient.get(`/categories/children/1`)
        categories.value = cats.data
    } catch (err) {
        console.log('Eroare fetch categories: ', err)
        handleApiError(err)
    }
}
async function fetchBouquetsCategory(bouquets, category_id, top_category_id) {
    generalError.value = null
    let buq

    try {
        if (top_category_id != null && top_category_id !== '')
            buq = await axiosClient.get(
                `/products?top_category_id=${top_category_id}`,
            )
        else if (category_id != null && category_id !== '')
            buq = await axiosClient.get(`/products?category_id=${category_id}`)
        else buq = await axiosClient.get(`/products`)

        bouquets.value = buq.data.data.slice(0, 4)
    } catch (err) {
        console.log('Eroare fetch buchete: ', err)
        handleApiError(err)
    }
}

onMounted(() => {
    fetchCartoons(cartoons)
    fetchBouquetsCategory(bouquets, null, 1)
    fetchBouquetsCategory(bouquets_valentines, 7, null)
    fetchBouquetsCategory(bouquets_mom, 5, null)
    fetchCategories(categories)
})

const cartoons = ref([])
const bouquets = ref([])
const categories = ref([])
const bouquets_valentines = ref([])
const bouquets_mom = ref([])
</script>

<template>
    <div class="mt-0 mb-10 overflow-x-hidden sm:mt-10">
        <div class="relative right-1/2 left-1/2 -mx-[50vw] w-screen">
            <div class="mx-auto max-w-11/12 sm:max-w-10/12">
                <MyCarouselV2 />
                <BenefitsSectionV2 />
                <Banner1 :img="Slide1" to="/buchete-de-flori" />
                <ProductSectionType1
                    :has-tablouri="true"
                    :products="cartoons"
                    background=""
                    description="Creează-ți propriul tablou cartoon – tu trimiți fotografia, noi desenăm cu suflet. Ilustrații personalizate, perfecte pentru cadouri speciale."
                    link="/toamna"
                    title="Tablouri Cartoon"
                />
            </div>
        </div>
        <div
            class="relative right-1/2 left-1/2 -mx-[50vw] w-screen bg-gray-200/70"
        >
            <div class="mx-auto max-w-11/12 sm:max-w-10/12">
                <ProductSectionType2
                    :categories="categories"
                    :has-tablouri="false"
                    :products="bouquets"
                    background=""
                    description="Alege un buchet cu flori de toamnă – culori calde, texturi inspirate din natură. Comandă flori online cu livrare în 2–4 ore."
                    link="/toamna"
                    title="Buchete din satin"
                />
            </div>
        </div>
        <div class="relative right-1/2 left-1/2 -mx-[50vw] w-screen">
            <div class="mx-auto max-w-11/12 sm:max-w-10/12">
                <ProductSectionType1
                    :has-tablouri="false"
                    :products="bouquets_valentines"
                    background=""
                    description="Buchete romantice, gândite pentru cei care vor să transforme un „te iubesc” într-un moment de neuitat."
                    link="/toamna"
                    title="Valentine's Day"
                />
            </div>
        </div>
        <div
            class="relative right-1/2 left-1/2 -mx-[50vw] w-screen bg-gray-200/70"
        >
            <div class="mx-auto max-w-11/12 sm:max-w-10/12">
                <ProductSectionType2
                    :has-tablouri="false"
                    :products="bouquets_mom"
                    background=""
                    description="Buchete personalizate, perfecte pentru a spune „mulțumesc” celor mai dragi ființe într-un mod cu adevărat special. 🌷💗"
                    link="/toamna"
                    title="Pentru Mama"
                />
            </div>
        </div>

        <!--footer-->
        <div class="relative right-1/2 left-1/2 -mx-[50vw] w-screen">
            <div class="mx-auto max-w-11/12 sm:max-w-10/12">
                <Subscribe />
            </div>
        </div>
    </div>
</template>

<style scoped></style>
