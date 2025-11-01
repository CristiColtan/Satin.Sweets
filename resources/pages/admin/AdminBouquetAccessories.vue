<template>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h1 class="mt-2 font-sans text-3xl text-amber-900">
                Accesorii buchete
            </h1>
            <button
                class="bg-rosegold-500 hover:bg-rosegold-700 rounded px-3 py-2 font-semibold text-white"
                @click="showAddNewAccessoryModal"
            >
                <span class="text-xl">Adauga accesoriu</span>
            </button>
        </div>
        <BouquetAccessoriesTable @clickEdit="editBouquetAccessory" />
        <BouquetAccessoriesModal
            v-model="showBouquetAccessoryModal"
            :bouquet_accessory_addon="bouquetAccessoryModel"
            @close="onModalClose"
        />
        <ErrorAlert :message="pageError" />
    </div>
</template>

<script setup>
import BouquetAccessoriesModal from '../../components/core/modals/BouquetAccessoriesModal.vue'
import BouquetAccessoriesTable from '../../components/tables/BouquetAccessoriesTable.vue'
import { useAppStore } from '../../store/index.js'
import { ref } from 'vue'
import ErrorAlert from '../../components/core/ErrorAlert.vue'
import { extractApiError } from '../../utils/apiError.js'

const store = useAppStore()

const DEFAULT_BOUQUET_ACCESSORY_ADDON = {
    id: '',
    name: '',
    description: ' ',
    hex_code: '#ffffff',
    price: 0,
    is_active: true,
    categories: [],
}

const bouquetAccessoryModel = ref({ ...DEFAULT_BOUQUET_ACCESSORY_ADDON })
const showBouquetAccessoryModal = ref(false)
const pageError = ref(null)

function showAddNewAccessoryModal() {
    showBouquetAccessoryModal.value = true
}

async function editBouquetAccessory(b) {
    pageError.value = null
    try {
        const { data } = await store.getAddon(b.id)
        bouquetAccessoryModel.value = data.data
        showAddNewAccessoryModal()
    } catch (err) {
        const { message } = extractApiError(err, {
            defaultMessage: 'Nu s-a putut obtine accesoriul.',
        })
        pageError.value = message
    }
}

function onModalClose() {
    bouquetAccessoryModel.value = { ...DEFAULT_BOUQUET_ACCESSORY_ADDON }
}
</script>
