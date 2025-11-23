<template>
    <section class="w-full py-10">
        <div :class="background === 'white' ? 'bg-white' : ''" class="gap-12">
            <!-- up -->
            <div class="mb-12 text-center">
                <div class="mb-5 flex items-center justify-center gap-4">
                    <div class="w-full border-b-2"></div>
                    <span
                        class="font-serif text-3xl font-bold text-nowrap text-gray-800 lg:text-3xl"
                    >
                        {{ title }}
                    </span>
                    <div class="w-full border-b-2"></div>
                </div>
                <p class="hidden font-serif text-xl text-gray-600">
                    Buchete pline de rafinament pentru momentele speciale
                </p>
                <div
                    v-if="categories && categories.length > 0"
                    class="mt-2 flex flex-wrap justify-center gap-2"
                >
                    <div v-for="(category, i) in categories" :key="i">
                        <button
                            class="hover:outline-rosegold-500 bg-white px-2 py-0.5 transition-transform duration-300 hover:outline hover:outline-2"
                            style="border-radius: 100px"
                        >
                            <span class="font-serif text-lg text-gray-600">{{
                                category.name
                            }}</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- down with products -->
            <div
                class="grid grid-cols-2 gap-4 py-2 lg:grid-cols-3 lg:gap-10 lg:px-4 xl:grid-cols-4"
            >
                <RouterLink
                    v-for="(product, i) in products"
                    :key="i"
                    :class="
                        background === 'white' ? 'bg-[#f3f3f3]' : 'bg-white'
                    "
                    :to="`/produs/${product.slug}`"
                    class="product-card group overflow-hidden rounded-2xl border-0"
                >
                    <div
                        :class="hasTablouri === false ? 'aspect-square' : ''"
                        class="relative overflow-hidden"
                    >
                        <img
                            v-if="
                                (Array.isArray(product.media) &&
                                    product.media.length > 0 &&
                                    product.media[0].full_url) ||
                                (Array.isArray(product.images) &&
                                    product.images.length > 0 &&
                                    product.images[0].url)
                            "
                            :alt="
                                product.media?.[0]?.alt_text ||
                                product.images?.[0]?.alt_text ||
                                product.title
                            "
                            :src="
                                product.media?.[0]?.full_url ||
                                product.images?.[0]?.url
                            "
                            class="w-auto rounded-md object-cover transition-transform duration-300 group-hover:scale-105"
                        />

                        <div
                            v-if="product.badge"
                            class="bg-rosegold-700 absolute top-4 left-4 rounded-full px-2 py-1 text-white"
                        >
                            <span class="font-serif text-lg">{{
                                product.badge
                            }}</span>
                        </div>

                        <button
                            class="group absolute top-4 right-4 bg-white/80 p-1 shadow-lg transition-transform duration-300 hover:scale-105"
                            style="border-radius: 100px"
                            @click.stop.prevent="
                                onToggleFavorite(product, $event)
                            "
                        >
                            <Heart
                                :class="
                                    store.isFavorite(product?.id)
                                        ? 'fill-rosegold-700 text-rosegold-700'
                                        : 'text-rosegold-700 hover:fill-rosegold-700'
                                "
                                class="h-6 w-6"
                            ></Heart>
                        </button>

                        <button
                            v-if="hasTablouri === true"
                            class="bg-rosegold-500 hover:bg-rosegold-700 absolute bottom-3 left-1/2 mt-3 -translate-x-1/2 px-3 py-2 text-white opacity-90"
                            style="border-radius: 10px"
                        >
                            <span
                                class="font-serif text-lg font-semibold whitespace-nowrap"
                                >Comanda acum!</span
                            >
                        </button>
                    </div>
                    <div
                        class="relative flex flex-col items-center justify-center"
                    >
                        <span
                            v-if="hasTablouri === false"
                            class="text-rosegold-900 mt-4 mb-2 text-center font-serif text-xl font-medium lg:text-2xl"
                        >
                            {{ product.title }}
                        </span>
                        <div
                            v-if="hasTablouri === false"
                            class="pb-1 font-serif text-[17px] text-gray-500 lg:text-lg"
                        >
                            <span
                                v-if="product?.discounted_price"
                                class="font-semibold"
                            >
                                {{ product?.discounted_price }}
                            </span>
                            <span
                                :class="[
                                    product?.discounted_price
                                        ? 'ml-2 line-through'
                                        : '',
                                ]"
                                >{{ product?.price }}</span
                            >
                        </div>
                        <div
                            v-if="hasTablouri === false"
                            class="bg-rosegold-500 hover:bg-rosegold-700 mx-2 mb-3 px-6 py-2 text-white opacity-90"
                            style="border-radius: 20px"
                        >
                            <span
                                class="font-serif text-[17px] font-semibold md:text-lg"
                                >Comanda acum!</span
                            >
                        </div>
                    </div>
                </RouterLink>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Heart } from 'lucide-vue-next'
import { useFieldErrors } from '../../../utils/useFieldErrors.js'
import { useAppStore } from '../../../store/index.js'

const store = useAppStore()

defineProps({
    title: String,
    description: String,
    link: String,
    products: Array,
    background: String,
    hasTablouri: Boolean,
    variant: String,
    categories: Array,
})

const { formErrors, generalError, handleApiError } = useFieldErrors()
function onToggleFavorite(p, e) {
    e?.stopPropagation?.()
    store.toggleFavorite(p).catch((err) => {
        console.error('Eroare toggle favorite', err)
        handleApiError(err)
    })
}
</script>

<style scoped>
.modal-text {
    text-align: justify;
    text-justify: inter-word;
}

:deep(.swiper-pagination-bullet-active) {
    background: rosybrown; /* activ */
    opacity: 1;
}

.product-card {
    box-shadow: 0 0 0 rgba(0, 0, 0, 0);
    transition: box-shadow 0.3s ease-in-out;
}

.product-card:hover {
    box-shadow:
        0 20px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>
