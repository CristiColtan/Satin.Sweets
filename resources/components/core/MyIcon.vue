<template>
    <component
        :is="Icon"
        v-if="!href"
        class="pulse-hover h-10 w-auto cursor-pointer transition-transform duration-200 ease-out will-change-transform"
    />

    <a
        v-else
        :aria-label="ariaLabel"
        :href="href"
        class="inline-flex"
        rel="noopener noreferrer"
        target="_blank"
    >
        <component
            :is="Icon"
            class="pulse-hover h-10 w-auto cursor-pointer transition-transform duration-200 ease-out will-change-transform"
        />
    </a>
</template>

<script setup>
import { computed } from 'vue'
import { icons } from '../../assets/svgs/index.js'

const props = defineProps({
    href: {
        type: String,
        default: '',
    },
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        default: '',
    },
})

const Icon = computed(() => icons[props.name])
const ariaLabel = computed(() => props.label || props.name)
</script>

<style scoped>
@keyframes bump {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.08);
    }
    100% {
        transform: scale(1);
    }
}

.pulse-hover:hover {
    animation: bump 420ms ease-in-out;
}
</style>
