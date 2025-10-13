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
                    class="modal-text mt-4 text-[16px] leading-relaxed text-gray-600"
                >
                    {{ description }}
                </p>

                <button
                    class="bg-rosegold-500 hover:bg-rosegold-700 px-3 py-2 text-white transition"
                    style="border-radius: 10px; margin-top: 20px"
                >
                    <div class="flex items-center justify-between">
                        <span class="rounded-2xl text-[16px]"
                            >Vezi mai multe</span
                        >
                    </div>
                </button>
            </div>

            <!-- right with products -->
            <div
                class="grid grid-cols-2 gap-4 md:col-span-3 lg:grid-cols-3 lg:gap-10"
            >
                <div
                    v-for="(product, i) in products"
                    :key="i"
                    :class="
                        background === 'white' ? 'bg-[#f3f3f3]' : 'bg-white'
                    "
                    class="product-card group overflow-hidden rounded-2xl border-0"
                >
                    <div
                        :class="hasTablouri === false ? 'aspect-square' : ''"
                        class="relative overflow-hidden"
                    >
                        <img
                            :src="product.img"
                            alt=""
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
                        >
                            <!--TODO: add favorite condition-->
                            <Heart
                                class="text-rosegold-700 hover:fill-rosegold-700 h-6 w-6"
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
                            {{ product.name }}
                        </span>
                        <p
                            v-if="hasTablouri === false"
                            class="font-serif text-[17px] text-gray-500 lg:text-lg"
                        >
                            {{ product.price }}
                        </p>
                        <button
                            v-if="hasTablouri === false"
                            class="bg-rosegold-500 hover:bg-rosegold-700 mx-2 mb-3 px-6 py-2 text-white opacity-90"
                            style="border-radius: 20px"
                        >
                            <span
                                class="font-serif text-[17px] font-semibold md:text-lg"
                                >Comanda acum!</span
                            >
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Heart } from 'lucide-vue-next'

defineProps({
    title: String,
    description: String,
    link: String,
    products: Array,
    background: String,
    hasTablouri: Boolean,
    variant: String,
})
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
