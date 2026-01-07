<template>
    <div class="mt-10 mb-10 overflow-x-hidden">
        <div class="relative right-1/2 left-1/2 -mx-[50vw] w-screen">
            <div class="mx-auto max-w-11/12 sm:max-w-10/12">
                <section class="w-full">
                    <div class="gap-12 bg-[#f3f3f3]">
                        <!-- up -->
                        <div class="mb-12 text-center">
                            <div
                                class="mb-1 flex items-center justify-center gap-4"
                            >
                                <div class="w-full border-b-2"></div>
                                <span
                                    class="font-serif text-3xl font-bold text-nowrap text-gray-800 lg:text-3xl"
                                >
                                    Lista de dorințe
                                </span>
                                <div class="w-full border-b-2"></div>
                            </div>
                            <p class="font-serif text-xl text-gray-600">
                                Cadourile tale pline de rafinament se află aici.
                            </p>
                        </div>

                        <!-- down with products -->
                        <div
                            class="grid grid-cols-2 gap-4 py-2 lg:grid-cols-3 lg:gap-10 lg:px-4 xl:grid-cols-4"
                        >
                            <RouterLink
                                v-for="(product, i) in store.favorites.items"
                                :key="i"
                                :class="
                                    background === 'white'
                                        ? 'bg-[#f3f3f3]'
                                        : 'bg-white'
                                "
                                :to="`/produs/${product.slug}`"
                                class="product-card group overflow-hidden rounded-2xl border-0"
                            >
                                <div
                                    class="relative aspect-square overflow-hidden"
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
                                </div>
                                <div
                                    class="relative flex flex-col items-center justify-center gap-2"
                                >
                                    <span
                                        class="text-rosegold-900 mt-4 mb-2 text-center font-serif text-xl font-medium lg:text-2xl"
                                    >
                                        {{ product.title }}
                                    </span>

                                    <div
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

                                    <button
                                        class="bg-rosegold-500 hover:bg-rosegold-700 mx-2 mb-3 px-6 py-2 text-white opacity-90"
                                        style="border-radius: 20px"
                                    >
                                        <span
                                            class="font-serif text-[17px] font-semibold md:text-lg"
                                            >Comandă acum!</span
                                        >
                                    </button>
                                </div>
                            </RouterLink>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useAppStore } from '../store/index.js'
import { Heart } from 'lucide-vue-next'
import { useFieldErrors } from '../utils/useFieldErrors.js'

const store = useAppStore()

defineProps({
    background: {
        type: String,
        default: '',
    },
})

const { generalError, handleApiError } = useFieldErrors()

function onToggleFavorite(p, e) {
    e?.stopPropagation?.()
    store.toggleFavorite(p).catch((err) => {
        console.error('Eroare toggle favorite', err)
        handleApiError(err)
    })
}
</script>
