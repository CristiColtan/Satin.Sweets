<template>
    <TransitionRoot :show="modelValue" as="template">
        <Dialog as="div" class="relative z-10" @close="closeModal">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/80 transition-opacity"></div>
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                        >
                            <div
                                class="flex flex-col items-start justify-between px-4 py-3"
                            >
                                <button
                                    class="absolute top-4 right-4 p-1 text-black"
                                    @click="closeModal"
                                >
                                    <span
                                        class="rounded-full text-2xl hover:bg-gray-100 hover:text-gray-300"
                                        ><X class="h-5 w-5"
                                    /></span>
                                </button>
                                <div
                                    class="bg-rosegold-100 mb-6 inline-flex rounded-xl p-2"
                                >
                                    <component
                                        :is="benefit.icon"
                                        class="text-rosegold-700 h-10 w-10"
                                    />
                                </div>
                                <span
                                    class="text-foreground mb-3 font-serif text-3xl font-bold"
                                >
                                    {{ benefit.title }}
                                </span>
                                <p class="text-muted mb-3 font-serif text-lg">
                                    {{ benefit.description }}
                                </p>
                                <p
                                    class="modal-text mb-3 font-serif text-lg leading-relaxed"
                                >
                                    {{ benefit.details }}
                                </p>
                                <button
                                    class="bg-rosegold-700 hover:bg-rosegold-500 mt-8 w-full py-2 text-white transition"
                                    style="border-radius: 10px"
                                    @click="closeModal"
                                >
                                    <span class="rounded-2xl text-[14px]"
                                        >Am înțeles</span
                                    >
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { X } from 'lucide-vue-next'
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'

defineProps({
    modelValue: { type: Boolean, required: true },
    benefit: { type: Object, default: null },
})

const emit = defineEmits(['update:modelValue'])
function closeModal() {
    emit('update:modelValue', false)
}
</script>

<style scoped>
.modal-text {
    text-align: justify;
    text-justify: inter-word;
}
</style>
