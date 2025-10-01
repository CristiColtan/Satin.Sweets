<template>
    <div
        class="flex flex-wrap items-center justify-between gap-6 rounded-lg border px-4 py-6"
    >
        <div
            v-for="(benefit, index) in benefits"
            :key="index"
            class="flex aspect-square w-30 flex-col items-center rounded-lg text-center shadow-md"
        >
            <div class="mb-2 text-2xl">
                <component :is="benefit.icon" class="h-9 w-9" />
            </div>
            <p class="font-serif text-lg">{{ benefit.title }}</p>
            <p v-if="benefit.subtitle" class="text-lg font-thin text-black">
                {{ benefit.subtitle }}
            </p>
        </div>
    </div>
</template>

<script setup>
import { ClockIcon, MapIcon } from '@heroicons/vue/24/outline/index.js'

const benefits = [
    {
        icon: MapIcon,
        title: 'Romania',
        subtitle: '24h',
    },
    {
        icon: ClockIcon,
        title: 'Etern',
    },
]
</script>
