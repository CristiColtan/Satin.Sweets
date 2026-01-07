<template>
    <router-link
        :to="to"
        class="relative mt-12 mb-2 block w-full cursor-pointer overflow-hidden rounded-lg"
    >
        <img :src="img" alt="Banner" class="h-64 w-full object-cover" />
    </router-link>
</template>

<script setup>
defineProps({
    to: { type: String, required: true }, // ruta din Vue Router
    img: { type: String, required: true }, // imagine banner
})
</script>
