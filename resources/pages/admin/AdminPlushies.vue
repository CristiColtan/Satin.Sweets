<template>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h1 class="mt-2 font-sans text-3xl text-amber-900">Plusuri</h1>
            <button
                class="bg-rosegold-500 hover:bg-rosegold-700 rounded px-3 py-2 font-semibold text-white"
                @click="showAddNewPlushieModal"
            >
                <span class="text-xl">Adauga plusuri</span>
            </button>
        </div>
        <PlushiesTable @clickEdit="editPlushie" />
        <PlushiesModal
            v-model="showPlushieModal"
            :plushie_addon="plushieModel"
            @close="onModalClose"
        />
        <ErrorAlert :message="pageError" />
    </div>
</template>

<script setup>
import { useAppStore } from '../../store/index.js'
import { ref } from 'vue'
import PlushiesModal from '../../components/core/modals/PlushiesModal.vue'
import PlushiesTable from '../../components/tables/PlushiesTable.vue'
import ErrorAlert from '../../components/core/ErrorAlert.vue'
import { extractApiError } from '../../utils/apiError.js'

const store = useAppStore()
const DEFAULT_PLUSHIE_ADDON = {
    id: '',
    name: '',
    description: ' ',
    hex_code: '#ffffff',
    price: 0,
    is_active: true,
    categories: [],
}

const plushieModel = ref({ ...DEFAULT_PLUSHIE_ADDON })
const showPlushieModal = ref(false)
const pageError = ref(null)

function showAddNewPlushieModal() {
    showPlushieModal.value = true
}

async function editPlushie(p) {
    pageError.value = null
    try {
        const { data } = await store.getAddon(p.id)
        plushieModel.value = data.data
        showAddNewPlushieModal()
    } catch (err) {
        const { message } = extractApiError(err, {
            defaultMessage: 'Nu s-a putut obtine plusul.',
        })
        pageError.value = message
    }
}

function onModalClose() {
    plushieModel.value = { ...DEFAULT_PLUSHIE_ADDON }
}
</script>
