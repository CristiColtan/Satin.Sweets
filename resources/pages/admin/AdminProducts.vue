<template>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="my-5 flex items-center justify-between">
            <h1 class="text-rosegold-900 mt-2 font-serif text-3xl">Products</h1>
            <button
                class="bg-rosegold-500 hover:bg-rosegold-700 rounded px-3 py-2 font-semibold text-white"
                @click="showAddNewProductModal"
            >
                <span class="font-serif text-xl">Adaugă produs</span>
            </button>
        </div>
        <ProductsTable @clickEdit="editProduct" />
        <ProductModal
            v-model="showProductModal"
            :product="productModel"
            @close="onModalClose"
        />
        <ErrorAlert :message="pageError" />
    </div>
</template>

<script setup>
import ProductsTable from '../../components/tables/ProductsTable.vue'
import ProductModal from '../../components/core/modals/ProductModal.vue'
import { useAppStore } from '../../store/index.js'
import { ref } from 'vue'
import { extractApiError } from '../../utils/apiError.js'
import ErrorAlert from '../../components/core/ErrorAlert.vue'

const store = useAppStore()

const DEFAULT_PRODUCT = {
    id: '',
    title: '',
    description: '',
    price: '',
    published: false,
    badge: '',
    discounted_price: '',
    additional_info: [],
    images: [],
    categories: [],
}

const productModel = ref({ ...DEFAULT_PRODUCT })
const showProductModal = ref(false)
const pageError = ref(null)

function showAddNewProductModal() {
    showProductModal.value = true
}

async function editProduct(p) {
    pageError.value = null
    try {
        const { data } = await store.getProduct(p.id)
        productModel.value = data.data
        showAddNewProductModal()
    } catch (err) {
        const { message } = extractApiError(err, {
            defaultMessage: 'Nu s-a putut obtine produsul.',
        })
        pageError.value = message
    }
}

function onModalClose() {
    productModel.value = { ...DEFAULT_PRODUCT }
}
</script>
