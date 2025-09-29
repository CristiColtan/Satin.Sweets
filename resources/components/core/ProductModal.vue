<template>
    <TransitionRoot :show="show" as="template">
        <Dialog as="div" class="relative z-10" @close="show = false">
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
                            <Spinner
                                v-if="loading"
                                class="absolute top-0 right-0 bottom-0 left-0 flex items-center justify-center bg-white"
                            ></Spinner>
                            <header
                                class="flex items-center justify-between px-4 py-3"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="line-clamp-2 text-lg leading-6 font-medium text-gray-900"
                                >
                                    {{
                                        product.id
                                            ? `Actualizeaza produsul: "${props.product.title}"`
                                            : 'Creeaza un produs'
                                    }}
                                </DialogTitle>
                                <button
                                    class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-full transition-colors hover:bg-[rgba(0,0,0,0.2)]"
                                    @click="closeModal"
                                >
                                    <svg
                                        class="h-6 w-6"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M6 18L18 6M6 6l12 12"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                    </svg>
                                </button>
                            </header>
                            <form @submit.prevent="onSubmit">
                                <div class="px-4 sm:p-6">
                                    <MyInput
                                        v-model="product.title"
                                        class="mb-3"
                                        label="Nume produs"
                                    />
                                    <MyInput
                                        v-model="product.description"
                                        class="mb-3"
                                        label="Descriere produs"
                                        type="textarea"
                                    />
                                    <MyInput
                                        v-model="product.price"
                                        class="mb-3"
                                        label="Pret"
                                        prepend="RON"
                                        type="number"
                                    />
                                    <MyInput
                                        v-model="newImages"
                                        class="mb-3"
                                        label="Imagini"
                                        type="file"
                                        @change="onFilesChange"
                                    />
                                    <!-- PREVIEW: Imagini EXISTENTE -->
                                    <div
                                        v-if="existingImages.length"
                                        class="mt-3"
                                    >
                                        <h4
                                            class="mb-2 text-sm font-medium text-gray-700"
                                        >
                                            Imagini existente
                                        </h4>
                                        <div class="flex flex-wrap gap-3">
                                            <div
                                                v-for="img in existingImages"
                                                :key="img.id"
                                                class="relative h-24 w-24 overflow-hidden rounded-lg border border-gray-300"
                                            >
                                                <img
                                                    :src="getImageSrc(img)"
                                                    alt=""
                                                    class="h-full w-full object-cover"
                                                />
                                                <button
                                                    class="absolute top-1 right-1 rounded bg-black/60 px-1.5 py-0.5 text-xs text-white"
                                                    title="Șterge imaginea"
                                                    type="button"
                                                    @click="
                                                        removeExisting(img.id)
                                                    "
                                                >
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PREVIEW: Imagini NOI -->
                                    <div v-if="newImages.length" class="mt-4">
                                        <h4
                                            class="mb-2 text-sm font-medium text-gray-700"
                                        >
                                            Imagini noi
                                        </h4>
                                        <div class="flex flex-wrap gap-3">
                                            <div
                                                v-for="(img, i) in newImages"
                                                :key="i"
                                                class="relative h-24 w-24 overflow-hidden rounded-lg border border-gray-300"
                                            >
                                                <img
                                                    :src="getImageSrc(img)"
                                                    alt=""
                                                    class="h-full w-full object-cover"
                                                />
                                                <button
                                                    class="absolute top-1 right-1 rounded bg-black/60 px-1.5 py-0.5 text-xs text-white"
                                                    title="Elimină din selecția nouă"
                                                    type="button"
                                                    @click="removeNew(i)"
                                                >
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <MyInput
                                        v-model="product.published"
                                        class="mb-3"
                                        label="Publicat"
                                        type="checkbox"
                                    />
                                </div>
                                <footer
                                    class="gap-3 bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                                >
                                    <button
                                        class="bg-rosegold-500 hover:bg-rosegold-700 focus:ring-rosegold-500 mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 px-4 py-2 text-lg font-medium text-white shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto"
                                    >
                                        <span class="text-lg">Salveaza</span>
                                    </button>
                                    <button
                                        ref="cancelButtonRef"
                                        class="focus:ring-rosegold-500 mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-lg font-medium text-gray-700 shadow-sm hover:bg-gray-200 focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto"
                                        type="button"
                                        @click="closeModal"
                                    >
                                        <span class="text-lg">Anuleaza</span>
                                    </button>
                                </footer>
                            </form>
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
import { computed, ref, watch } from 'vue'
import MyInput from './MyInput.vue'
import { useAppStore } from '../../store/index.js'

const store = useAppStore()
const loading = ref(false)
const props = defineProps({
    modelValue: Boolean,
    product: {
        required: true,
        type: Object,
    },
})

function removeExisting(id) {
    existingImages.value = existingImages.value.filter((img) => img.id !== id)
    if (!removedImageIds.value.includes(id)) {
        removedImageIds.value.push(id)
    }
}

function removeNew(idx) {
    newImages.value.splice(idx, 1)
}

function onFilesChange(filesArray) {
    const files = (filesArray || []).filter((file) => file instanceof File)
    if (files.length) newImages.value.push(...files)
}

function getImageSrc(img) {
    // dacă e fișier uploadat
    if (img instanceof File) {
        return URL.createObjectURL(img)
    }
    // dacă e imagine existentă din API
    if (img.url) {
        return img.url
    }
    return null
}

const emit = defineEmits(['update:modelValue', 'close'])
const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
})

const existingImages = ref([])
const newImages = ref([])
const removedImageIds = ref([])

const product = ref({
    id: props.product.id,
    title: props.product.title,
    description: props.product.description,
    price: props.product.price,
    published: props.product.published,
    images: [],
})

watch(
    () => props.product,
    (newVal) => {
        if (newVal) {
            console.log(
                'Produs nou:',
                newVal,
                existingImages.value,
                newImages.value,
                removedImageIds.value,
            )
            product.value = { ...newVal }
            existingImages.value = Array.isArray(newVal.images)
                ? [...newVal.images]
                : []
            newImages.value = []
            removedImageIds.value = []
        }
    },
    { deep: true, immediate: true },
)

watch(
    removedImageIds,
    (newVal) => {
        console.log('Removed image ids:', newVal)
    },
    { deep: true, immediate: true },
)

watch(
    product,
    (newVal) => {
        console.log(
            'Produs modificat:',
            newVal,
            existingImages.value,
            newImages.value,
            removedImageIds.value,
        )
    },
    { deep: true },
)

function closeModal() {
    show.value = false
    emit('close')
}

function onSubmit() {
    loading.value = true
    if (product.value.id) {
        store
            .updateProduct(
                product.value,
                newImages.value,
                removedImageIds.value,
            )
            .then((response) => {
                loading.value = false
                console.log('Produs actualizat:', response.data)
                store.getProducts()
                closeModal()
            })
    } else {
        store
            .createProduct(product.value, newImages.value)
            .then((response) => {
                loading.value = false
                console.log('Produs creat:', response.data)
                store.getProducts()
                closeModal()
            })
            .catch((err) => {
                loading.value = false
                debugger
            })
    }
}
</script>
