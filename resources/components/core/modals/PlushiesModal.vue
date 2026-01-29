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
                                        plushie_addon.id
                                            ? `Actualizeaza plusul: "${props.plushie_addon.name}"`
                                            : 'Adauga un plus'
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
                                    <label class="text-lg">Nume plus</label>
                                    <MyInput
                                        v-model="plushie.name"
                                        class="mb-3"
                                        label="Nume plus"
                                        @input="formErrors.name = null"
                                    />
                                    <p
                                        v-if="formErrors.name"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ formErrors.name }}
                                    </p>
                                    <label class="text-lg">Imagini</label>
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
                                            Imagine existenta
                                        </h4>
                                        <div class="flex flex-wrap gap-3">
                                            <div
                                                v-for="(
                                                    img, i
                                                ) in existingImages"
                                                :key="i"
                                                class="relative h-24 w-24 overflow-hidden rounded-lg border border-gray-300"
                                            >
                                                <img
                                                    :src="getImageSrc(img)"
                                                    alt=""
                                                    class="h-full w-full object-cover"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PREVIEW: Imagini NOI -->
                                    <div v-if="newImages.length" class="mt-4">
                                        <h4
                                            class="mb-2 text-sm font-medium text-gray-700"
                                        >
                                            Imagine noua
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
                                            </div>
                                        </div>
                                    </div>
                                    <label class="text-lg">Culoare</label>
                                    <input
                                        v-model="plushie.hex_code"
                                        class="mb-3 w-full"
                                        type="color"
                                    />

                                    <label class="text-lg"
                                        >Subcategorie add-on</label
                                    >
                                    <MyInput
                                        v-model="plushie.sub_type"
                                        class="mb-3"
                                        label="Subcategorie"
                                    />

                                    <label class="text-lg">Descriere</label>
                                    <MyInput
                                        v-model="plushie.description"
                                        class="mb-3"
                                        label="Descriere sclipici"
                                        type="textarea"
                                    />
                                    <label class="text-lg">Pret</label>

                                    <MyInput
                                        v-model="plushie.price"
                                        class="mb-3"
                                        label="Pret"
                                        prepend="RON"
                                        type="number"
                                        @input="formErrors.price = null"
                                    />
                                    <p class="text-lg">Destinat categoriei</p>
                                    <Multiselect
                                        v-model="plushie.categories"
                                        :clear-on-select="false"
                                        :close-on-select="false"
                                        :disabled="
                                            loadingCategories || categoriesError
                                        "
                                        :multiple="true"
                                        :options="parentCategories"
                                        :preserve-search="true"
                                        class="rounded"
                                        label="name"
                                        placeholder="Selectează categoriile..."
                                        track-by="id"
                                        @update:modelValue="
                                            () => (formErrors.categories = null)
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

                                    <ErrorAlert :message="generalError" />
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
                                        class="group mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 shadow-sm hover:bg-gray-200 sm:mt-0 sm:ml-3 sm:w-auto"
                                        type="button"
                                        @click="closeModal"
                                    >
                                        <span class="text-lg font-medium"
                                            >Anulează</span
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
import axiosClient from '../../../js/axios.js'
import { useAppStore } from '../../../store/index.js'
import { computed, onMounted, ref, watch } from 'vue'
import MyInput from '../MyInput.vue'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import { extractApiError } from '../../../utils/apiError.js'
import { useFieldErrors } from '../../../utils/useFieldErrors.js'
import ErrorAlert from '../ErrorAlert.vue'

const store = useAppStore()
const loading = ref(false)
const props = defineProps({
    modelValue: Boolean,
    plushie_addon: {
        required: true,
        type: Object,
    },
})

const emit = defineEmits(['update:modelValue', 'close'])
const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
})

const parentCategories = ref([])
const newImages = ref([])
const existingImages = ref([])

const loadingCategories = ref(false)
const categoriesError = ref(null)

const plushie = ref({
    id: props.plushie_addon.id,
    name: props.plushie_addon.name,
    description: props.plushie_addon.description,
    hex_code: props.plushie_addon.hex_code,
    image: props.plushie_addon.image,
    price: props.plushie_addon.price,
    is_active: props.plushie_addon.is_active,
    sub_type: props.plushie_addon.sub_type,
    categories: [],
})

function onFilesChange(filesArray) {
    const files = (filesArray || []).filter((file) => file instanceof File)
    if (files.length) newImages.value.push(...files)
}

function getImageSrc(img) {
    // dacă e fișier uploadat
    if (img instanceof File) {
        return URL.createObjectURL(img)
    }
    if (typeof img === 'string') {
        return img
    }

    if (img && img.url) {
        return img.url
    }
    return null
}

onMounted(async () => {
    loadingCategories.value = true
    categoriesError.value = null
    try {
        const res = await axiosClient.get('/categories/parents')
        parentCategories.value = res.data
    } catch (err) {
        const { message, status } = extractApiError(err, {
            defaultMessage: 'Eroare fetch categorii parinte din baza de date.',
        })
        categoriesError.value = message
    } finally {
        loadingCategories.value = false
    }
})

watch(
    () => props.plushie_addon,
    (newVal) => {
        if (newVal) {
            console.log('Plushie nou:', newVal)
            console.log('Existing images:', existingImages.value)
            plushie.value = { ...newVal }
            existingImages.value = []
            if (newVal.image) {
                existingImages.value.push({ url: newVal.image })
            }
            newImages.value = []
        }
    },
    { deep: true, immediate: true },
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
            ...plushie.value,
            categories: plushie.value.categories.map((cat) => cat.id),
            type: 'plushies',
        }

        if (plushie.value.id) {
            await store.updateAddon(payload, newImages.value)
        } else {
            await store.createAddon(payload, newImages.value)
        }
        await store.getAddons({ type: 'plushies' })
        closeModal()
    } catch (err) {
        handleApiError(err)
    } finally {
        loading.value = false
    }
}
</script>
