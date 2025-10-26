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
    </div>
</template>

<script setup>
import { useAppStore } from '../../store/index.js'
import { ref } from 'vue'
import PlushiesModal from '../../components/core/modals/PlushiesModal.vue'
import PlushiesTable from '../../components/tables/PlushiesTable.vue'

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

function showAddNewPlushieModal() {
    showPlushieModal.value = true
}

function editPlushie(p) {
    store.getAddon(p.id).then(({ data }) => {
        plushieModel.value = data.data
        showAddNewPlushieModal()
    })
}

function onModalClose() {
    plushieModel.value = { ...DEFAULT_PLUSHIE_ADDON }
}
</script>
