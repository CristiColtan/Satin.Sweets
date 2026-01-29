<template>
    <div
        v-if="message || message2"
        class="mt-5 flex flex-col items-center justify-center rounded-lg bg-red-100 px-3 py-2 text-center text-red-700 shadow-md"
    >
        <p
            v-if="message"
            class="flex translate-y-1 text-center font-serif text-lg"
        >
            {{ message }}
        </p>

        <p
            v-if="message2"
            class="flex translate-y-1 text-center font-serif text-lg"
        >
            {{ message2 }}
        </p>
    </div>
</template>

<script setup>
const props = defineProps({
    message: { type: String, default: '' },
    message2: { type: String, default: '' },
})
</script>
