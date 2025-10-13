<template>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h1 class="mt-2 font-sans text-3xl text-amber-900">Products</h1>
            <button
                class="bg-rosegold-500 hover:bg-rosegold-700 rounded px-3 py-2 font-semibold text-white"
                @click="showAddNewProductModal"
            >
                <span class="text-xl">Adauga produs</span>
            </button>
        </div>
        <ProductsTable @clickEdit="editProduct" />
        <ProductModal
            v-model="showProductModal"
            :product="productModel"
            @close="onModalClose"
        />
    </div>
</template>

<script setup>
import ProductsTable from '../../components/ProductsTable.vue'
import ProductModal from '../../components/core/ProductModal.vue'
import { useAppStore } from '../../store/index.js'
import { computed, ref } from 'vue'

const store = useAppStore()

const DEFAULT_PRODUCT = {
    id: '',
    title: '',
    description: '',
    price: '',
    published: false,
    images: [],
    categories: [],
}

const products = computed(() => store.products)
const productModel = ref({ ...DEFAULT_PRODUCT })
const showProductModal = ref(false)

function showAddNewProductModal() {
    showProductModal.value = true
}

function editProduct(p) {
    store.getProduct(p.id).then(({ data }) => {
        //const { id, title, description, price, published } = data.data
        productModel.value = data.data
        //console.log('productmodel', productModel.value)
        showAddNewProductModal()
    })
}

function onModalClose() {
    productModel.value = { ...DEFAULT_PRODUCT }
}
</script>
