<template>
    <Disclosure v-slot="{ open }" as="nav" class="bg-rosegold-500">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-24 items-center justify-between">
                <div
                    class="absolute inset-y-0 left-0 flex items-center sm:hidden"
                >
                    <DisclosureButton
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-black hover:bg-white/5 hover:text-white focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500"
                    >
                        <span class="absolute -inset-0.5" />
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon
                            v-if="!open"
                            aria-hidden="true"
                            class="block size-8"
                        />
                        <XMarkIcon
                            v-else
                            aria-hidden="true"
                            class="block size-8"
                        />
                    </DisclosureButton>
                </div>

                <div
                    class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start sm:px-6"
                >
                    <div class="flex shrink-0 items-center">
                        <img
                            :src="logo"
                            alt="LOGO"
                            class="h-20 w-auto md:h-24"
                            @click="redirectHome"
                        />
                    </div>
                </div>

                <div
                    class="inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
                >
                    <p
                        class="mr-10 flex translate-y-1.5 items-center text-lg font-medium text-black md:text-2xl"
                    >
                        ADMIN PANEL
                    </p>
                    <button
                        class="relative rounded-full p-1 text-black transition-transform duration-200 hover:-translate-y-1 hover:text-white focus:outline-2 focus:outline-offset-2"
                        type="button"
                        @click="redirectHome"
                    >
                        <span class="absolute -inset-1.5" />
                        <span class="sr-only">View notifications</span>
                        <ArrowLeftStartOnRectangleIcon
                            aria-hidden="true"
                            class="size-8"
                        />
                    </button>
                </div>
            </div>
        </div>
        <DisclosurePanel class="sm:hidden">
            <div class="flex flex-col space-y-3 px-4 pt-2 pb-3">
                <RouterLink
                    v-for="item in navigation"
                    :key="item.name"
                    :class="[
                        isActive(item)
                            ? 'border-b-1 text-white'
                            : 'text-white hover:border-b-1',
                        'cursor-pointer border-white font-sans text-lg',
                    ]"
                    :href="item.href"
                    :to="item.to"
                    >{{ item.name }}</RouterLink
                >
            </div>
        </DisclosurePanel>
    </Disclosure>
    <Disclosure
        v-slot="{ open }"
        as="nav"
        class="bg-rosegold-700 hidden sm:block"
        ><div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-14 items-center justify-between">
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex -translate-y-0.5 space-x-5">
                        <RouterLink
                            v-for="item in navigation"
                            :key="item.name"
                            :class="[
                                isActive(item)
                                    ? 'border-b-1 text-white'
                                    : 'text-white hover:border-b-1',
                                'border-white font-sans text-lg',
                            ]"
                            :to="item.to"
                            >{{ item.name }}</RouterLink
                        >
                    </div>
                </div>
            </div>
        </div></Disclosure
    >
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { RouterLink, useRoute, useRouter } from 'vue-router'
import {
    ArrowLeftStartOnRectangleIcon,
    Bars3Icon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'

import logo from '@/assets/logo4.png'
import { useAppStore } from '../store/index.js'

const route = useRoute()
const router = useRouter()
const store = useAppStore()

const navigation = [
    {
        name: 'Dashboard',
        to: { name: 'admin.dashboard' },
    },
    {
        name: 'Products',
        to: { name: 'admin.products' },
    },
    {
        name: 'Glitter',
        to: { name: 'admin.glitter' },
    },
    {
        name: 'Plushies',
        to: { name: 'admin.plushies' },
    },
    {
        name: 'Bouquets Accessories',
        to: {
            name: 'admin.bouquets-accessories',
        },
    },
]

function handleLogout() {
    store.logout()
    router.push({ name: 'login' })
}
//not used for this moment
function redirectHome() {
    router.push({ name: 'app.home' })
}
const isActive = (item) => route.name === item.to?.name
</script>
