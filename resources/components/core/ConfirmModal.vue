<template>
    <TransitionRoot :show="show" as="template">
        <Dialog
            as="div"
            class="relative z-10"
            @close="
                () => {
                    if (!loading) closeModal()
                }
            "
        >
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
                            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md"
                        >
                            <Spinner
                                v-if="loading"
                                class="absolute top-0 right-0 bottom-0 left-0 flex items-center justify-center bg-white"
                            ></Spinner>
                            <header
                                class="flex flex-col items-center justify-center px-4 py-3"
                            >
                                <DialogTitle
                                    as="p"
                                    class="line-clamp-2 flex py-3 text-center text-3xl leading-6 font-medium text-gray-900"
                                >
                                    {{ title }}
                                </DialogTitle>
                                <div
                                    class="mb-1 rounded-full bg-red-100 p-2 transition-colors"
                                >
                                    <component
                                        :is="PackageX"
                                        class="h-15 w-15 text-red-600"
                                    />
                                </div>
                            </header>
                            <div class="px-5 py-1 text-center text-lg">
                                <p>{{ message }}</p>
                            </div>

                            <div class="">
                                <div class="mt-2 grid grid-cols-2 gap-0">
                                    <button
                                        :disabled="loading"
                                        class="border px-4 py-2 text-gray-700 hover:bg-gray-200/80"
                                        type="button"
                                        @click="closeModal"
                                    >
                                        <span class="text-lg font-medium">{{
                                            cancelText
                                        }}</span>
                                    </button>
                                    <button
                                        :disabled="loading"
                                        class="bg-red-600 px-4 py-2 font-medium text-white hover:bg-red-700 disabled:opacity-60"
                                        type="button"
                                        @click="onConfirm"
                                    >
                                        <span
                                            v-if="!loading"
                                            class="text-lg font-medium"
                                            >{{ confirmText }}</span
                                        >
                                        <span v-else class="text-lg font-medium"
                                            >Se șterge...</span
                                        >
                                    </button>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import Spinner from './Spinner.vue'
import { PackageX } from 'lucide-vue-next'

import { computed } from 'vue'

const props = defineProps({
    modelValue: { type: Boolean, default: false },
    title: { type: String, default: 'Confirmă acțiunea' },
    message: { type: String, default: 'Ești sigur(ă) că vrei să continui?' },
    confirmText: { type: String, default: 'Șterge' },
    cancelText: { type: String, default: 'Anulează' },
    loading: { type: Boolean, default: false },
})

const emit = defineEmits(['update:modelValue', 'close', 'confirm'])
const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
})
function closeModal() {
    show.value = false
    emit('close')
}

function onConfirm() {
    if (props.loading) return
    emit('confirm')
}
</script>
