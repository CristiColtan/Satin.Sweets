<template>
    <section class="py-10">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
            <!-- Coloana stângă -->
            <div
                class="flex flex-col items-center justify-center md:col-span-1"
            >
                <div class="flex w-full items-center justify-center border-b">
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
                    class="bg-rosegold-700 hover:bg-rosegold-500 px-3 py-2 text-white transition"
                    style="border-radius: 10px; margin-top: 20px"
                >
                    <div class="flex items-center justify-between">
                        <span class="rounded-2xl text-[16px]"
                            >Vezi mai multe</span
                        >
                    </div>
                </button>
            </div>

            <!-- Coloana dreaptă: produse -->
            <div
                class="grid grid-cols-1 gap-10 sm:grid-cols-2 md:col-span-3 lg:grid-cols-3"
            >
                <div
                    v-for="(product, i) in products"
                    :key="i"
                    class="product-card bg-card overflow-hidden rounded-2xl border-0"
                >
                    <div class="relative aspect-square overflow-hidden">
                        <img
                            :src="product.img"
                            alt=""
                            class="w-auto rounded-md object-cover"
                        />

                        <div
                            v-if="product.badge"
                            class="bg-rosegold-500 absolute top-4 left-4 rounded-full px-2 py-1"
                        >
                            {{ product.badge }}
                        </div>
                    </div>
                    <h3 class="mt-4 text-center font-medium">
                        {{ product.name }}
                    </h3>
                    <p class="text-sm text-gray-500">{{ product.price }}</p>
                    <button
                        class="mt-3 rounded-full bg-green-900 px-6 py-2 text-white hover:bg-green-700"
                    >
                        Comandă acum
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
defineProps({
    title: String,
    description: String,
    link: String,
    products: Array,
    background: String,
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
