<template>
    <div
        v-if="benefit"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @click="$emit('close')"
    >
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <div
            class="animate-in fade-in zoom-in-95 relative w-full max-w-lg duration-300"
            @click.stop
        >
            <div class="bg-card relative rounded-2xl p-8 shadow-2xl">
                <button
                    class="hover:bg-muted absolute top-4 right-4 rounded-full p-2"
                    @click="$emit('close')"
                >
                    <X class="h-5 w-5" />
                    <span class="sr-only">Închide</span>
                </button>

                <div class="bg-primary/10 mb-6 inline-flex rounded-xl p-4">
                    <component
                        :is="benefit.icon"
                        class="text-primary h-10 w-10"
                    />
                </div>

                <h3 class="text-foreground mb-3 font-serif text-3xl font-bold">
                    {{ benefit.title }}
                </h3>

                <p class="text-muted-foreground mb-4 text-lg">
                    {{ benefit.description }}
                </p>

                <p
                    class="text-foreground text-align-justify w-full leading-relaxed"
                >
                    {{ benefit.details }}
                </p>

                <button
                    class="bg-primary hover:bg-primary/90 mt-6 w-full rounded-lg py-3 text-white transition"
                    @click="$emit('close')"
                >
                    <span class="text-lg">Am înțeles</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, watch } from 'vue'
import { X } from 'lucide-vue-next'

const props = defineProps({
    benefit: {
        type: Object,
        default: null,
    },
})

onMounted(() => {
    if (props.benefit) {
        document.body.style.overflow = 'hidden'
    }
})

onBeforeUnmount(() => {
    document.body.style.overflow = 'unset'
})

watch(
    () => props.benefit,
    (newVal) => {
        document.body.style.overflow = newVal ? 'hidden' : 'unset'
    },
)
</script>
