<template>
    <section class="py-10">
        <div
            :class="background === 'white' ? 'bg-white' : ''"
            class="sm:grid-colts-2 grid grid-cols-1 gap-12 py-2 md:grid-cols-4 lg:px-4"
        >
            <!-- left -->
            <div
                class="flex flex-col items-center justify-center md:col-span-1"
            >
                <div class="flex w-full items-center justify-center border-b-2">
                    <span
                        class="pb-2 text-center font-serif text-3xl font-bold text-gray-800"
                    >
                        {{ title }}
                    </span>
                </div>
                <p
                    class="modal-text mt-4 text-[16px] leading-relaxed text-gray-600 sm:text-[17px]"
                >
                    {{ description }}
                </p>

                <button
                    class="bg-rosegold-500 hover:bg-rosegold-700 px-3 py-2 text-white transition"
                    style="border-radius: 10px; margin-top: 20px"
                >
                    <div class="flex items-center justify-between">
                        <span class="rounded-2xl text-[16px] font-medium"
                            >Vezi mai multe</span
                        >
                    </div>
                </button>
            </div>

            <!-- right with products -->
            <div
                class="grid grid-cols-2 gap-4 md:col-span-3 lg:grid-cols-3 lg:gap-10"
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
                                >Comandă acum!</span
                            >
                        </button>
                    </div>
                    <div
                        class="relative flex flex-col items-center justify-center gap-2"
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

                        <button
                            v-if="hasTablouri === false"
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
</template>

<script setup>
import { Heart } from 'lucide-vue-next'
import { useFieldErrors } from '../../utils/useFieldErrors.js'
import { useAppStore } from '../../store/index.js'

const store = useAppStore()

defineProps({
    title: String,
    description: String,
    link: String,
    products: Array,
    background: String,
    hasTablouri: Boolean,
    variant: String,
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
