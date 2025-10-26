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
                                        glitter_addon.id
                                            ? `Actualizeaza sclipiciul: "${props.glitter_addon.name}"`
                                            : 'Adauga un sclipici'
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
                                        v-model="glitter.name"
                                        class="mb-3"
                                        label="Nume sclipici"
                                    />
                                    <label class="text-lg">Culoare</label>
                                    <input
                                        v-model="glitter.hex_code"
                                        class="mb-3 w-full"
                                        type="color"
                                    />
                                    <label class="text-lg">Descriere</label>
                                    <MyInput
                                        v-model="glitter.description"
                                        class="mb-3"
                                        label="Descriere sclipici"
                                        type="textarea"
                                    />
                                    <MyInput
                                        v-model="glitter.price"
                                        class="mb-3"
                                        label="Pret"
                                        prepend="RON"
                                        type="number"
                                    />
                                    <p class="text-lg">Categorie</p>
                                    <Multiselect
                                        v-model="glitter.categories"
                                        :clear-on-select="false"
                                        :close-on-select="false"
                                        :multiple="true"
                                        :options="parentCategories"
                                        :preserve-search="true"
                                        class="rounded"
                                        label="name"
                                        placeholder="Selectează categoriile..."
                                        track-by="id"
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
                                        class="group focus:ring-rosegold-500 mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-lg font-medium text-gray-700 shadow-sm hover:bg-gray-200 focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto"
                                        type="button"
                                        @click="closeModal"
                                    >
                                        <span
                                            class="text-lg group-hover:text-gray-600"
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
import { useAppStore } from '../../../store/index.js'
import { computed, onMounted, ref, watch } from 'vue'
import MyInput from '../MyInput.vue'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'

import axiosClient from '../../../js/axios.js'

const store = useAppStore()
const loading = ref(false)
const props = defineProps({
    modelValue: Boolean,
    glitter_addon: {
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

const glitter = ref({
    id: props.glitter_addon.id,
    name: props.glitter_addon.name,
    description: props.glitter_addon.description,
    hex_code: props.glitter_addon.hex_code,
    price: props.glitter_addon.price,
    is_active: props.glitter_addon.is_active,
    categories: [],
})

onMounted(async () => {
    try {
        const res = await axiosClient.get('/categories/parents')
        parentCategories.value = res.data
    } catch (err) {
        console.log('Eroare fetch categorii parinte din baza de date: ', err)
    }
})

watch(
    () => props.glitter_addon,
    (newVal) => {
        if (newVal) {
            console.log('Glitter nou:', newVal)
            glitter.value = { ...newVal }
        }
    },
    { deep: true, immediate: true },
)

function closeModal() {
    show.value = false
    emit('close')
}

async function onSubmit() {
    loading.value = true
    try {
        const payload = {
            ...glitter.value,
            categories: glitter.value.categories.map((cat) => cat.id),
            type: 'glitters',
        }

        if (glitter.value.id) {
            await store.updateAddon(payload)
            loading.value = false
            await store.getAddons({ type: 'glitters' })
            closeModal()
        } else {
            await store.createAddon(payload)
            loading.value = false
            await store.getAddons({ type: 'glitters' })
            closeModal()
        }
    } catch (err) {
        console.group('🛑 Eroare la salvarea sclipiciului')
        console.log('err:', err)
        console.log('status:', err?.response?.status)
        console.log('data:', err?.response?.data)
        console.groupEnd()
    } finally {
        loading.value = false
    }
}
</script>
