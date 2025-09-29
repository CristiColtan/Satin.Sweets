<template>
    <div class="animate-fade-in-down rounded-lg bg-white p-4 shadow">
        <div
            class="grid grid-rows-2 gap-y-4 border-b-2 pb-3 sm:flex sm:justify-between"
        >
            <div class="flex items-center">
                <span class="mr-3 font-sans whitespace-nowrap sm:text-lg"
                    >Per Page</span
                >
                <select
                    v-model="perPage"
                    class="focus:ring-rosegold-500 focus:border-rosegold-500 relative block w-16 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:outline-none sm:text-sm"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="ml-3 font-sans sm:text-lg"
                    >Found
                    <span class="text-rosegold-900">{{ products?.total }}</span>
                    products</span
                >
            </div>
            <div>
                <input
                    v-model="search"
                    class="focus:ring-rosegold-500 focus:border-rosegold-500 relative block w-48 rounded-md border border-gray-300 px-3 py-2 text-2xl text-gray-900 placeholder-gray-500 placeholder:text-lg focus:z-10 focus:outline-none"
                    placeholder="Cauta produs.."
                />
            </div>
        </div>
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <TableHeaderCell
                        :sort-direction="sortDirection"
                        :sort-field="sortField"
                        field="id"
                        @click="sortProducts('id')"
                        >ID</TableHeaderCell
                    >
                    <TableHeaderCell
                        :sort-direction="sortDirection"
                        :sort-field:="sortField"
                        field="image"
                    >
                        Imagine
                    </TableHeaderCell>
                    <TableHeaderCell
                        :sort-direction="sortDirection"
                        :sort-field="sortField"
                        field="title"
                        @click="sortProducts('title')"
                        >Titlu</TableHeaderCell
                    >
                    <TableHeaderCell
                        :sort-direction="sortDirection"
                        :sort-field="sortField"
                        field="price"
                        @click="sortProducts('price')"
                        >Pret</TableHeaderCell
                    >
                    <TableHeaderCell
                        :sort-direction="sortDirection"
                        :sort-field="sortField"
                        field="updated_at"
                        @click="sortProducts('updated_at')"
                        >Ultima modificare</TableHeaderCell
                    >
                    <TableHeaderCell field="actions">Actions</TableHeaderCell>
                </tr>
            </thead>
            <tbody v-if="products.loading || !products.data.length">
                <tr>
                    <td colspan="5">
                        <Spinner
                            v-if="products.loading"
                            :text="'Se incarca...'"
                        />
                        <p v-else class="py-8 text-center text-gray-700">
                            Nu exista produse inregistrate!
                        </p>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr v-for="(product, index) of products.data" class="text-lg">
                    <td class="border-b p-2">
                        {{ product.id }}
                    </td>
                    <td class="border-b p-2">
                        <img
                            v-if="
                                Array.isArray(product.images) &&
                                product.images.length > 0 &&
                                product.images[0].url
                            "
                            :alt="product.images[0].alt_text || product.title"
                            :src="product.images[0].url"
                            class="h-24 w-24 object-cover"
                        />
                        <span v-else class="text-gray-400 italic"
                            >Fără imagine</span
                        >
                    </td>

                    <td
                        class="max-w-[200px] overflow-hidden border-b p-2 text-ellipsis whitespace-nowrap"
                        v-html="product._formatted?.title || product.title"
                    ></td>

                    <td class="border-black p-2">
                        {{ product.price }}
                    </td>
                    <td class="border-b p-2">
                        {{ product.updated_at }}
                    </td>
                    <td class="border-b p-2">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="bg-opacity-0 hover:bg-opacity-5 focus:bg-opacity-5 focus-visible:ring-opacity-75 inline-flex h-10 w-10 items-center justify-center rounded-full text-lg font-medium text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                                    ><EllipsisVerticalIcon
                                        aria-hidden="true"
                                        class="text-md hover:text-rosegold-500 h-8 w-8 text-gray-900"
                                /></MenuButton>
                            </div>
                            <transition
                                enter-active-class="transition duration-100 ease-out"
                                enter-from-class="transform scale-95 opacity-0"
                                enter-to-class="transform scale-100 opacity-100"
                                leave-active-class="transition duration-75 ease-in"
                                leave-from-class="transform scale-100 opacity-100"
                                leave-to-class="transform scale-95 opacity-0"
                            >
                                <MenuItems
                                    class="absolute right-0 z-10 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black focus:outline-none"
                                >
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                                                    active
                                                        ? 'bg-rosegold-300 text-white'
                                                        : 'text-gray-900',
                                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                ]"
                                                @click="editProduct(product)"
                                            >
                                                <PencilIcon
                                                    :active="active"
                                                    class="text-rosegold-700 group-hover:text-rosegold-700 mr-2 h-5 w-5"
                                                />
                                                Edit
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                                                    active
                                                        ? 'bg-rosegold-300 text-white'
                                                        : 'text-gray-900',
                                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                ]"
                                                @click="deleteProduct(product)"
                                            >
                                                <TrashIcon
                                                    :active="active"
                                                    class="text-rosegold-700 group-hover:text-rosegold-700 mr-2 h-5 w-5"
                                                />
                                                Delete
                                            </button>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </td>
                </tr>
            </tbody>
        </table>

        <div
            v-if="!products.loading"
            class="mt-5 flex items-center justify-between"
        >
            <div
                v-if="products.data.length"
                class="flex items-center font-sans text-[14px] whitespace-pre-wrap"
            >
                Showing from
                <span class="text-rosegold-500"> {{ products.from }} </span> to
                <span class="text-rosegold-500">{{ products.to }}</span> of
                <span class="text-rosegold-500">{{ products.total }}</span>
                products
            </div>
            <nav
                v-if="products.total > products.limit"
                aria-label="Pagination"
                class="relative z-0 inline-flex justify-center -space-x-px rounded-md shadow-sm"
            >
                <a
                    v-for="(link, i) of products.links"
                    :key="i"
                    :class="[
                        link.active
                            ? 'bg-rosegold-100 border-rosegold-500 z-10 text-white'
                            : 'border-gray-300 bg-white text-gray-500 hover:bg-gray-50',
                        i === 0 ? 'rounded-l-md' : '',
                        i === products.links.length - 1 ? 'rounded-r-md' : '',
                        !link.url
                            ? 'cursor-not-allowed bg-gray-100 text-gray-700 opacity-50'
                            : '',
                    ]"
                    :disabled="!link.url"
                    aria-current="page"
                    class="relative inline-flex items-center border px-4 py-2 text-sm font-medium whitespace-nowrap"
                    href="#"
                    @click="getForPage($event, link)"
                    v-html="link.label"
                >
                </a>
            </nav>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue'
import TableHeaderCell from '@/components/core/MyTableHeaderCell.vue'
import { useAppStore } from '../store/index.js'
import { PRODUCTS_PER_PAGE } from '../js/constants.js'
import Spinner from './core/Spinner.vue'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { EllipsisVerticalIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'

const store = useAppStore()

const perPage = ref(PRODUCTS_PER_PAGE)
const search = ref('')
const sortField = ref('updated_at')
const sortDirection = ref('desc')
const product = ref({})

const products = computed(() => store.products)
const emit = defineEmits(['clickEdit'])

const showProductModal = ref(false)

watch(search, () => {
    getProducts()
})

onMounted(() => {
    getProducts()
})

function getForPage(ev, link) {
    ev.preventDefault()
    if (!link.url || link.active) return
    getProducts(link.url)
}
function getProducts(url = null) {
    store.getProducts({
        url,
        search: search.value,
        per_page: perPage.value,
        sort_field: sortField.value,
        sort_direction: sortDirection.value,
    })
}
function sortProducts(field) {
    if (field === sortField.value) {
        if (sortDirection.value === 'desc') {
            sortDirection.value = 'asc'
        } else {
            sortDirection.value = 'desc'
        }
    } else {
        sortField.value = field
        sortDirection.value = 'asc'
    }

    getProducts()
}

function deleteProduct(p) {
    if (!confirm('Esti sigur ca vrei sa stergi acest produs?')) return
    store.deleteProduct(p.id).then((res) => {
        store.getProducts()
    })
}

function showAddNewModal() {
    showProductModal.value = true
}
function editProduct(p) {
    emit('clickEdit', p)
}
</script>
