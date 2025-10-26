<template>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h1 class="mt-2 font-sans text-3xl text-amber-900">Sclipici</h1>
            <button
                class="bg-rosegold-500 hover:bg-rosegold-700 rounded px-3 py-2 font-semibold text-white"
                @click="showAddNewGlitterModal"
            >
                <span class="text-xl">Adauga sclipici</span>
            </button>
        </div>
        <GlitterTable @clickEdit="editGlitter" />
        <GlitterModal
            v-model="showGlitterModal"
            :glitter_addon="glitterModel"
            @close="onModalClose"
        />
    </div>
</template>

<script setup>
import GlitterTable from '../../components/tables/GlitterTable.vue'
import GlitterModal from '../../components/core/modals/GlitterModal.vue'
import { ref } from 'vue'
import { useAppStore } from '../../store/index.js'

const store = useAppStore()

const DEFAULT_GLITTER_ADDON = {
    id: '',
    name: '',
    description: ' ',
    hex_code: '#ffffff',
    price: 0,
    is_active: true,
    categories: [],
}

const glitterModel = ref({ ...DEFAULT_GLITTER_ADDON })
const showGlitterModal = ref(false)

function showAddNewGlitterModal() {
    showGlitterModal.value = true
}

function editGlitter(g) {
    store.getAddon(g.id).then(({ data }) => {
        glitterModel.value = data.data
        showAddNewGlitterModal()
    })
}

function onModalClose() {
    glitterModel.value = { ...DEFAULT_GLITTER_ADDON }
}
</script>
