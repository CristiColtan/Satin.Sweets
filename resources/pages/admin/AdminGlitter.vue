<template>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="my-5 flex items-center justify-between">
            <h1 class="text-rosegold-900 mt-2 font-serif text-3xl">Sclipici</h1>
            <button
                class="bg-rosegold-500 hover:bg-rosegold-700 rounded px-3 py-2 font-semibold text-white"
                @click="showAddNewGlitterModal"
            >
                <span class="font-serif text-xl">Adaugă sclipici</span>
            </button>
        </div>
        <GlitterTable @clickEdit="editGlitter" />
        <GlitterModal
            v-model="showGlitterModal"
            :glitter_addon="glitterModel"
            @close="onModalClose"
        />
        <ErrorAlert :message="pageError" />
    </div>
</template>

<script setup>
import GlitterTable from '../../components/tables/GlitterTable.vue'
import GlitterModal from '../../components/core/modals/GlitterModal.vue'
import { ref } from 'vue'
import { useAppStore } from '../../store/index.js'
import { extractApiError } from '../../utils/apiError.js'
import ErrorAlert from '../../components/core/ErrorAlert.vue'

const store = useAppStore()

const DEFAULT_GLITTER_ADDON = {
    id: '',
    name: '',
    description: ' ',
    hex_code: '#ffffff',
    price: 0,
    is_active: true,
    sub_type: '',
    categories: [],
}

const glitterModel = ref({ ...DEFAULT_GLITTER_ADDON })
const showGlitterModal = ref(false)
const pageError = ref(null)

function showAddNewGlitterModal() {
    showGlitterModal.value = true
}

async function editGlitter(g) {
    pageError.value = null
    try {
        const { data } = await store.getAddon(g.id)
        glitterModel.value = data.data
        showAddNewGlitterModal()
    } catch (err) {
        const { message } = extractApiError(err, {
            defaultMessage: 'Nu s-a putut obtine sclipiciul.',
        })
        pageError.value = message
    }
}

function onModalClose() {
    glitterModel.value = { ...DEFAULT_GLITTER_ADDON }
}
</script>
