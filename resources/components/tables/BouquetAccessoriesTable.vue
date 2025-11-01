<template>
    <div class="animate-fade-in-down rounded-lg bg-white p-4 shadow">
        <div
            class="grid grid-rows-2 gap-y-4 border-b-2 pb-3 sm:flex sm:justify-between"
        >
            <div class="flex items-center">
                <span class="mr-3 font-sans whitespace-nowrap sm:text-lg"
                    >Per Page
                </span>
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
                    <span class="text-rosegold-900">{{
                        bouquets_accessories?.total
                    }}</span>
                    items
                </span>
            </div>

            <div>
                <input
                    v-model="search"
                    class="focus:ring-rosegold-500 focus:border-rosegold-500 relative block w-48 rounded-md border border-gray-300 px-3 py-2 text-2xl text-gray-900 placeholder-gray-500 placeholder:text-lg focus:z-10 focus:outline-none"
                    placeholder="Cauta accesorii.."
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
                        @click="sortBouquetAccessories('id')"
                        >ID</TableHeaderCell
                    ><TableHeaderCell
                        :sort-direction="sortDirection"
                        :sort-field="sortField"
                        field="name"
                        @click="sortBouquetAccessories('name')"
                        >Nume</TableHeaderCell
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
                        :sort-field:="sortField"
                        field="hex_code"
                    >
                        Culoare
                    </TableHeaderCell>

                    <TableHeaderCell
                        :sort-direction="sortDirection"
                        :sort-field="sortField"
                        field="price"
                        @click="sortBouquetAccessories('price')"
                    >
                        Pret (RON)
                    </TableHeaderCell>

                    <TableHeaderCell
                        :sort-direction="sortDirection"
                        :sort-field="sortField"
                        field="categories"
                    >
                        Destinat categoriei
                    </TableHeaderCell>

                    <TableHeaderCell
                        :sort-direction="sortDirection"
                        :sort-field="sortField"
                        field="type"
                    >
                        Tipul de Add-On
                    </TableHeaderCell>

                    <TableHeaderCell field="actions">Actions</TableHeaderCell>
                </tr>
            </thead>

            <tbody
                v-if="
                    bouquets_accessories.loading ||
                    !bouquets_accessories.data.length
                "
            >
                <tr>
                    <td colspan="5">
                        <Spinner
                            v-if="bouquets_accessories.loading"
                            :text="'Se incarca...'"
                        />
                        <p
                            v-else
                            class="py-8 text-center text-lg font-bold text-gray-700"
                        >
                            Nu exista accesorii inregistrate!
                        </p>
                    </td>
                </tr>
            </tbody>

            <tbody v-else>
                <tr
                    v-for="(accessory, index) of bouquets_accessories.data"
                    class="text-lg"
                >
                    <td class="border-b p-2">
                        {{ accessory.id }}
                    </td>
                    <td
                        class="border-b p-2"
                        v-html="accessory._formatted?.name || accessory.name"
                    ></td>
                    <td class="border-b p-2">
                        <img
                            v-if="
                                (Array.isArray(accessory.media) &&
                                    accessory.media.length > 0 &&
                                    accessory.media[0].full_url) ||
                                (Array.isArray(accessory.images) &&
                                    accessory.images.length > 0 &&
                                    accessory.images[0].url) ||
                                accessory.image
                            "
                            :alt="
                                accessory.media?.[0]?.alt_text ||
                                accessory.images?.[0]?.alt_text ||
                                accessory.image ||
                                accessory.title
                            "
                            :src="
                                accessory.media?.[0]?.full_url ||
                                accessory.images?.[0]?.url ||
                                accessory.image
                            "
                            class="h-24 w-24 object-cover"
                        />
                        <span v-else class="text-gray-400 italic"
                            >Fără imagine</span
                        >
                    </td>
                    <td class="border-b p-2">
                        <div
                            :style="{ backgroundColor: accessory.hex_code }"
                            class="h-10 w-10"
                        ></div>
                    </td>
                    <td class="border-black p-2">
                        {{ accessory.price }}
                    </td>
                    <td class="border-b p-2">
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="cat in accessory.categories"
                                :key="cat.id ?? cat"
                                class="bg-rosegold-500 rounded-full px-3 py-1 text-sm font-medium text-white"
                            >
                                {{ typeof cat === 'string' ? cat : cat.name }}
                            </span>
                        </div>
                    </td>
                    <td class="border-b p-2">
                        <span
                            class="bg-rosegold-900 rounded-full px-3 py-1 text-sm font-medium text-white"
                        >
                            {{ accessory.type }}
                        </span>
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
                                                @click="
                                                    editBouquetAccessory(
                                                        accessory,
                                                    )
                                                "
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
                                                @click="
                                                    deleteBouquetAccessories(
                                                        accessory,
                                                    )
                                                "
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
            v-if="!bouquets_accessories.loading"
            class="mt-5 flex items-center justify-between"
        >
            <div
                v-if="bouquets_accessories.data.length"
                class="flex items-center font-sans text-[14px] whitespace-pre-wrap"
            >
                Showing from
                <span class="text-rosegold-500">
                    {{ bouquets_accessories.from }}
                </span>
                to
                <span class="text-rosegold-500">{{
                    bouquets_accessories.to
                }}</span>
                of
                <span class="text-rosegold-500">{{
                    bouquets_accessories.total
                }}</span>
                glitters
            </div>
            <nav
                v-if="bouquets_accessories.total > bouquets_accessories.limit"
                aria-label="Pagination"
                class="relative z-0 inline-flex justify-center -space-x-px rounded-md shadow-sm"
            >
                <a
                    v-for="(link, i) of bouquets_accessories.links"
                    :key="i"
                    :class="[
                        link.active
                            ? 'bg-rosegold-100 border-rosegold-500 z-10 text-white'
                            : 'border-gray-300 bg-white text-gray-500 hover:bg-gray-50',
                        i === 0 ? 'rounded-l-md' : '',
                        i === bouquets_accessories.links.length - 1
                            ? 'rounded-r-md'
                            : '',
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
        <ErrorAlert
            :message="listTableError"
            :message2="deleteBouquetAccessoryError"
        />
    </div>
</template>

<script setup>
import { useAppStore } from '../../store/index.js'
import { ADDONS_PER_PAGE } from '../../js/constants.js'
import { computed, onMounted, ref, watch } from 'vue'
import TableHeaderCell from '../core/MyTableHeaderCell.vue'
import Spinner from '../core/Spinner.vue'
import {
    EllipsisVerticalIcon,
    PencilIcon,
    TrashIcon,
} from '@heroicons/vue/24/outline/index.js'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import ErrorAlert from '../core/ErrorAlert.vue'
import { extractApiError } from '../../utils/apiError.js'

const store = useAppStore()
const perPage = ref(ADDONS_PER_PAGE)
const search = ref('')
const sortField = ref('updated_at')
const sortDirection = ref('desc')

const bouquets_accessories = computed(() => store.addons.b_accessories)
const emit = defineEmits(['clickEdit'])
const listTableError = ref(null)
const deleteBouquetAccessoryError = ref(null)

watch([search, perPage], () => {
    getBouquetAccessories()
})

onMounted(() => {
    getBouquetAccessories()
})

function getForPage(ev, link) {
    ev.preventDefault()
    if (!link.url || link.active) return
    getBouquetAccessories(link.url)
}

async function getBouquetAccessories(url = null) {
    listTableError.value = null
    try {
        await store.getAddons({
            url,
            search: search.value,
            per_page: perPage.value,
            sort_field: sortField.value,
            sort_direction: sortDirection.value,
            type: 'b_accessories',
        })
    } catch (err) {
        const { message, status } = extractApiError(err, {
            defaultMessage: 'Nu s-au putut obtine accesoriile pentru buchete.',
        })
        listTableError.value = message
    }
}

function sortBouquetAccessories(field) {
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

    getBouquetAccessories()
}

async function deleteBouquetAccessories(bouquet_accessory) {
    deleteBouquetAccessoryError.value = null
    if (!confirm('Esti sigur ca vrei sa stergi acest accesoriu?')) return

    try {
        await store.deleteAddon(bouquet_accessory.id)
        await store.getAddons({
            search: search.value,
            per_page: perPage.value,
            sort_field: sortField.value,
            sort_direction: sortDirection.value,
            type: 'b_accessories',
        })
    } catch (err) {
        const { message, status } = extractApiError(err, {
            defaultMessage: 'Nu s-a putut sterge accesoriul pentru buchete.',
        })
        deleteBouquetAccessoryError.value = message
    }
}

function editBouquetAccessory(bouquet_accessory) {
    emit('clickEdit', bouquet_accessory)
}
</script>
