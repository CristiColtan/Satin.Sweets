<template>
    <div class="mx-auto mt-20 max-w-10/12">
        <div class="border-b border-b-gray-400">
            <div class="flex items-center gap-2">
                <RouterLink class="group flex items-center" to="/">
                    <ChevronLeft
                        class="group-hover:text-rosegold-500 text-rosegold-700 h-4 w-4"
                    />
                    <span
                        class="group-hover:text-rosegold-500 text-rosegold-700 font-serif"
                        >Acasa</span
                    >
                </RouterLink>
                <span class="font-serif font-semibold text-gray-500">/</span>
                <span class="text-rosegold-700 font-serif font-semibold">{{
                    product?.title
                }}</span>
            </div>
        </div>

        <div class="mt-20 grid gap-12 lg:grid-cols-2">
            <!--left-->
            <div class="space-y-4">
                <div
                    class="bg-muted relative aspect-square overflow-hidden rounded-2xl"
                >
                    <img
                        :src="product?.images[selectedImage].url"
                        alt="Product Image"
                        class="h-full w-full object-cover"
                    />

                    <div
                        v-if="product?.badge"
                        class="bg-rosegold-700/90 absolute top-4 left-4 rounded-full px-2 py-1 text-white"
                    >
                        <span class="font-serif text-lg">{{
                            product.badge
                        }}</span>
                    </div>

                    <button
                        class="group absolute top-4 right-4 bg-white/90 p-1 shadow-lg transition-transform duration-300 hover:scale-105"
                        style="border-radius: 100px"
                    >
                        <!--TODO: add favorite condition-->
                        <Heart
                            class="text-rosegold-700 hover:fill-rosegold-700 h-6 w-6"
                        ></Heart>
                    </button>
                </div>

                <div
                    class="flex gap-4 rounded-xl bg-[rgba(204,204,204,0.2)] p-2"
                >
                    <button
                        v-for="(image, i) in product?.images"
                        :key="i"
                        :class="
                            selectedImage === i
                                ? 'border-rosegold-500 border-2 shadow-md'
                                : 'hover:outline-2 hover:outline-gray-300'
                        "
                        class="relative aspect-square w-24 overflow-hidden"
                        style="border-radius: 10px"
                        @click="selectedImage = i"
                    >
                        <img
                            :alt="`${product?.name} ${i + 1}`"
                            :src="image.url"
                            class="h-full w-full object-cover"
                        />/>
                    </button>
                </div>
            </div>

            <!--right-->
            <div class="space-y-8 rounded-xl bg-[rgba(204,204,204,0.2)] p-3">
                <div class="">
                    <p
                        class="text-muted text-center font-serif text-3xl font-semibold tracking-tight lg:text-4xl"
                    >
                        {{ product?.title }}
                    </p>
                    <div class="mb-5 flex items-center justify-center gap-4">
                        <div class="w-full border-b-1"></div>
                        <span
                            class="text-md font-serif text-nowrap text-gray-800 lg:text-lg"
                        >
                            COD Produs:
                            <span class="font-semibold"
                                >SS-{{ product?.id }}</span
                            >
                        </span>
                        <div class="w-full border-b-1"></div>
                    </div>
                </div>

                <!-- step 1-->
                <div
                    v-if="product?.top_parent_categories?.some(cat => cat.name === 'Buchet')"
                    class="rounded-2xl border-2 border-gray-400/80 bg-[#f3f3f3] p-3"
                >
                    <div class="mb-2 flex justify-between">
                        <div class="flex gap-3">
                            <div
                                class="bg-rosegold-500 flex h-6 w-6 items-center justify-center rounded-full font-bold text-white"
                            >
                                1
                            </div>
                            <p
                                class="-translate-y-0.5 text-center font-serif text-lg"
                            >
                                Adauga panglica personalizata
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <p class="font-serif text-xl font-semibold">
                                +10 RON
                            </p>
                            <Check v-if="ribbonText.trim()"
                                class="h-6 w-6 text-green-800 transition-all duration-300"
                            />
                        </div>
                    </div>

                    <input v-model="ribbonText"
                           class="w-full rounded-lg border border-gray-500 focus:ring-rosegold-500"
                           placeholder="Scrie mesajul aici..."
                    type="text">
                    </input>
                </div>

                <!-- step 2-->
                <div
                    v-if="product?.top_parent_categories?.some(cat => cat.name === 'Buchet')"
                    class="rounded-2xl border-2 border-gray-400/80 bg-[#f3f3f3] p-3"
                >
                    <div class="mb-2 flex justify-between">
                        <div class="flex gap-3">
                            <div
                                class="bg-rosegold-500 flex h-6 w-6 items-center justify-center rounded-full font-bold text-white"
                            >
                                1
                            </div>
                            <p
                                class="-translate-y-0.5 text-center font-serif text-lg"
                            >
                                Adauga sclipici
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <p class="font-serif text-xl font-semibold">
                                +10 RON
                            </p>
                            <Check v-if="ribbonText.trim()"
                                   class="h-6 w-6 text-green-800 transition-all duration-300"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import axiosClient from '../js/axios.js'

import { Check, ChevronLeft, Heart } from 'lucide-vue-next'

import 'swiper/css'
import 'swiper/css/pagination'

const route = useRoute()
const product = ref(null)

const ribbonText = ref('')

const selectedImage = ref(0)

onMounted(async () => {
    const slug = route.params.slug
    try {
        const res = await axiosClient.get(`/product/${slug}`)
        product.value = res.data.data
    } catch (err) {
        console.log('Eroare fetch produs: ', err)
    }
})
</script>

<style scoped>

</style>
