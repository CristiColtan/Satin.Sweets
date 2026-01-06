<template>
    <Transition name="toast">
        <div
            v-if="toast.show"
            :class="{
                'bg-green-600': toast.type === 'success',
                'bg-red-600': toast.type === 'error',
                'bg-blue-600': toast.type === 'info',
                'bg-yellow-500': toast.type === 'warning',
            }"
            class="fixed top-4 right-4 z-50 max-w-sm rounded-md px-4 py-3 shadow-lg"
        >
            <span class="font-sans text-lg font-semibold text-white">{{
                toast.message
            }}</span>
        </div>
    </Transition>
</template>

<script setup>
import { useToastState } from '../../utils/myToast.js'

const toast = useToastState()
</script>

<style scoped>
.toast-enter-active,
.toast-leave-active {
    transition: all 0.2s ease-out;
}
.toast-enter-from,
.toast-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
