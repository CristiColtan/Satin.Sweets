<template>
    <TransitionRoot :show="show" as="template">
        <Dialog
            as="div"
            class="relative z-10"
            @close="
                () => {
                    if (!loading && !generalError) closeModal()
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
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-6xl"
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
                                <div class="grid grid-cols-2 gap-4 px-4 sm:p-6">
                                    <!--left-->
                                    <div>
                                        <label class="text-lg">Titlu</label>
                                        <MyInput
                                            v-model="product.title"
                                            class="mb-3"
                                            label="Nume produs"
                                            @input="formErrors.title = null"
                                        />
                                        <p
                                            v-if="formErrors.title"
                                            class="mt-1 text-sm text-red-600"
                                        >
                                            {{ formErrors.title }}
                                        </p>

                                        <label class="text-lg">Pret</label>
                                        <MyInput
                                            v-model="product.price"
                                            class="mb-3"
                                            label="Pret"
                                            prepend="RON"
                                            type="number"
                                            @input="formErrors.price = null"
                                        />
                                        <p
                                            v-if="formErrors.price"
                                            class="mt-1 text-sm text-red-600"
                                        >
                                            {{ formErrors.price }}
                                        </p>

                                        <label class="text-lg">Descriere</label>
                                        <MyInput
                                            v-model="product.description"
                                            class="mb-3"
                                            label="Descriere produs"
                                        />

                                        <label class="text-lg">Poze</label>
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
                                            <p class="mb-2 text-lg">
                                                Imagini existente
                                            </p>
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
                                                            removeExisting(
                                                                img.id,
                                                            )
                                                        "
                                                    >
                                                        ✕
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- PREVIEW: Imagini NOI -->
                                        <div
                                            v-if="newImages.length"
                                            class="mt-4"
                                        >
                                            <p class="mb-2 text-lg">
                                                Imagini noi
                                            </p>
                                            <div class="flex flex-wrap gap-3">
                                                <div
                                                    v-for="(
                                                        img, i
                                                    ) in newImages"
                                                    :key="i"
                                                    class="relative h-24 w-24 overflow-hidden rounded-lg border border-gray-300"
                                                >
                                                    <img
                                                        :src="getImageSrc(img)"
                                                        alt=""
                                                        class="h-full w-full object-cover"
                                                    />
                                                    <button
                                                        class="absolute top-1 right-1 rounded bg-black/60 px-3 py-1 text-xs text-white"
                                                        title="Elimină din selecția nouă"
                                                        type="button"
                                                        @click="removeNew(i)"
                                                    >
                                                        ✕
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <MyInput
                                            v-model="product.published"
                                            class="border-none shadow-none"
                                            label="Publicat"
                                            type="checkbox"
                                        />

                                        <label class="mt-3 mb-1 text-lg"
                                            >Categorii</label
                                        >
                                        <Multiselect
                                            v-model="product.categories"
                                            :clear-on-select="false"
                                            :close-on-select="false"
                                            :disabled="
                                                loadingCategories ||
                                                categoriesError
                                            "
                                            :multiple="true"
                                            :options="allCategories"
                                            :preserve-search="true"
                                            class="rounded"
                                            label="name"
                                            placeholder="Selectează categoriile..."
                                            track-by="id"
                                            @update:modelValue="
                                                () =>
                                                    (formErrors.categories =
                                                        null)
                                            "
                                        />

                                        <p
                                            v-if="formErrors.categories"
                                            class="mt-1 text-sm text-red-600"
                                        >
                                            {{ formErrors.categories }}
                                        </p>
                                        <p
                                            v-if="categoriesError"
                                            class="mt-1 text-sm text-red-600"
                                        >
                                            {{ categoriesError }}
                                        </p>
                                    </div>
                                    <!--right-->
                                    <div class="flex flex-col">
                                        <label class="text-lg">Eticheta</label>
                                        <MyInput
                                            v-model="product.badge"
                                            class="mb-3"
                                            label="Eg. NOU / DISCOUNT / REDUCERE"
                                        />

                                        <label class="text-lg">Discount</label>
                                        <MyInput
                                            v-model="product.discounted_price"
                                            class="mb-3"
                                            label="Pret redus"
                                            prepend="RON"
                                            type="number"
                                        />

                                        <p class="text-lg font-medium">
                                            Informatii suplimentare
                                        </p>

                                        <div
                                            v-for="(
                                                info, index
                                            ) in additionalInfo"
                                            :key="index"
                                            class="mb-1 flex gap-2"
                                        >
                                            <input
                                                v-model="info.key"
                                                class="flex-1 rounded border p-1 text-lg"
                                                placeholder="Eg. Componenta / Forma / Culoare"
                                                style="font-size: 15px"
                                            />
                                            <input
                                                v-model="info.value"
                                                class="flex-1 rounded border p-1 text-lg"
                                                placeholder="Eg. 17 x Trandafiri / Rotunda / Gri"
                                                style="font-size: 15px"
                                            />
                                            <button
                                                class="rounded bg-gray-300 px-1 py-0.5 font-bold text-black hover:bg-gray-400 hover:text-white"
                                                type="button"
                                                @click="
                                                    additionalInfo.splice(
                                                        index,
                                                        1,
                                                    )
                                                "
                                            >
                                                x
                                            </button>
                                        </div>

                                        <button
                                            :class="
                                                additionalInfo.length > 0
                                                    ? 'mt-2'
                                                    : 'mt-0'
                                            "
                                            class="bg-rosegold-500 hover:bg-rosegold-700 rounded px-3 py-1 text-white shadow"
                                            type="button"
                                            @click="
                                                additionalInfo.push({
                                                    key: '',
                                                    value: '',
                                                })
                                            "
                                        >
                                            <span class="text-base"
                                                >+ Adauga info</span
                                            >
                                        </button>

                                        <ErrorAlert :message="generalError" />
                                    </div>
                                </div>
                                <footer
                                    class="gap-3 bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                                >
                                    <button
                                        class="bg-rosegold-500 hover:bg-rosegold-700 focus:ring-rosegold-500 mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 px-4 py-2 text-lg font-medium text-white shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto"
                                        type="submit"
                                    >
                                        <span class="text-lg">Salveaza</span>
                                    </button>
                                    <button
                                        ref="cancelButtonRef"
                                        class="group mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 shadow-sm hover:bg-gray-400 sm:mt-0 sm:ml-3 sm:w-auto"
                                        type="button"
                                        @click="closeModal"
                                    >
                                        <span
                                            class="text-lg font-medium group-hover:text-gray-500"
                                            >Anuleaza</span
                                        >
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
import Spinner from '../Spinner.vue'
import { computed, onMounted, ref, watch } from 'vue'
import MyInput from '../MyInput.vue'
import { useAppStore } from '../../../store/index.js'
import axiosClient from '../../../js/axios.js'
import 'vue-multiselect/dist/vue-multiselect.css'
import Multiselect from 'vue-multiselect'
import { useFieldErrors } from '../../../utils/useFieldErrors.js'
import { extractApiError } from '../../../utils/apiError.js'
import ErrorAlert from '../ErrorAlert.vue'

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

const allCategories = ref([])
const additionalInfo = ref([])

const loadingCategories = ref(false)
const categoriesError = ref(null)

onMounted(async () => {
    loadingCategories.value = true
    categoriesError.value = null
    try {
        const res = await axiosClient.get('/categories')
        allCategories.value = res.data
    } catch (err) {
        const { message, status } = extractApiError(err, {
            defaultMessage: 'Eroare fetch categorii din baza de date:',
        })
        categoriesError.value = message
    } finally {
        loadingCategories.value = false
    }
})

const product = ref({
    id: props.product.id,
    title: props.product.title,
    description: props.product.description,
    badge: props.product.badge,
    price: props.product.price,
    discounted_price: props.product.discounted_price,
    published: props.product.published,
    additional_info: props.product.additional_info,
    images: [],
    categories: [],
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
                allCategories.value,
            )
            product.value = { ...newVal }
            existingImages.value = Array.isArray(newVal.images)
                ? [...newVal.images]
                : []

            if (newVal.additional_info) {
                additionalInfo.value = Object.entries(
                    newVal.additional_info,
                ).map(([key, value]) => ({ key, value }))
            } else {
                additionalInfo.value = []
            }

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

const { formErrors, generalError, handleApiError } = useFieldErrors()

async function onSubmit() {
    loading.value = true
    formErrors.value = {}
    generalError.value = null

    try {
        const payload = {
            ...product.value,
            categories: product.value.categories.map((cat) => cat.id),
            additional_info: Object.fromEntries(
                additionalInfo.value.map((item) => [item.key, item.value]),
            ),
        }

        if (product.value.id) {
            await store.updateProduct(
                payload,
                newImages.value,
                removedImageIds.value,
            )
        } else {
            await store.createProduct(payload, newImages.value)
        }

        await store.getProducts()
        closeModal()
    } catch (err) {
        handleApiError(err)
    } finally {
        loading.value = false
    }
}
</script>

<style scoped></style>
