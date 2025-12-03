<template>
    <div
        :class="isVisible ? 'translate-y-0' : '-translate-y-full'"
        class="fixed top-0 right-0 left-0 z-50 transition-transform duration-300"
    >
        <Disclosure v-slot="{ open }" as="nav" class="bg-rosegold-500">
            <div class="mx-auto max-w-10/12">
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
                                class="ml-4 h-20 w-auto sm:ml-0 md:h-24"
                                @click="redirectHome"
                            />
                        </div>
                    </div>
                    <div
                        class="inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
                    >
                        <button
                            :class="[
                                store.user?.data?.is_admin ? 'block' : 'hidden',
                                'relative rounded-full p-1 text-black transition-transform duration-200 hover:-translate-y-1 focus:outline-2 focus:outline-offset-2',
                            ]"
                            type="button"
                            @click="redirectAdmin"
                        >
                            <span class="absolute -inset-1.5" />
                            <span class="sr-only">View notifications</span>
                            <WrenchScrewdriverIcon
                                aria-hidden="true"
                                class="size-8"
                            />
                            <span
                                class="absolute -top-1 -right-1 flex items-center justify-center rounded-full bg-white px-1 text-[10px] font-bold text-red-600"
                            >
                                ADMIN
                            </span>
                        </button>
                        <button
                            class="relative rounded-full p-1 text-black transition-transform duration-200 hover:-translate-y-1 focus:outline-2 focus:outline-offset-2"
                            type="button"
                        >
                            <span class="absolute -inset-1.5" />
                            <span class="sr-only">View notifications</span>
                            <HeartIcon aria-hidden="true" class="size-8" />
                            <span
                                v-if="favoritesCount > 0"
                                class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-white text-[12px] font-bold text-black"
                            >
                                {{ favoritesCount }}
                            </span>
                        </button>
                        <button
                            class="relative rounded-full p-1 text-black transition-transform duration-200 hover:-translate-y-1 focus:outline-2 focus:outline-offset-2"
                            type="button"
                        >
                            <span class="absolute -inset-1.5" />
                            <span class="sr-only">View notifications</span>
                            <ShoppingBagIcon
                                aria-hidden="true"
                                class="size-8"
                            />
                            <span
                                class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-white text-[12px] font-bold text-black"
                            >
                                3
                            </span>
                        </button>
                        <button
                            class="relative rounded-full p-1 text-black transition-transform duration-200 hover:-translate-y-1 hover:text-white focus:outline-2 focus:outline-offset-2"
                            type="button"
                            @click="handleLogout"
                        >
                            <span class="absolute -inset-1.5" />
                            <span class="sr-only">View notifications</span>
                            <UserIcon aria-hidden="true" class="size-8" />
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
            ><div class="mx-auto max-w-10/12">
                <div class="relative flex h-14 items-center justify-between">
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex -translate-y-0.5 space-x-4">
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
            </div>
        </Disclosure>
    </div>

    <div class="pt-[7.5rem] sm:pt-[9.5rem]">
        <slot />
    </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { RouterLink, useRoute, useRouter } from 'vue-router'
import {
    Bars3Icon,
    HeartIcon,
    ShoppingBagIcon,
    UserIcon,
    WrenchScrewdriverIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'

import logo from '@/assets/logo4.png'
import { useAppStore } from '../store/index.js'
import { computed, onBeforeUnmount, onMounted, ref } from 'vue'

const route = useRoute()
const router = useRouter()
const store = useAppStore()

const navigation = [
    {
        name: 'Buchete de flori',
        to: { name: 'app.buchete-de-flori' },
    },
    {
        name: 'Tablouri personalizate',
        to: { name: 'app.tablouri-personalizate' },
    },
]

const favoritesCount = computed(() => store.favoritesCount)

function redirectHome() {
    router.push({ name: 'app.home' })
}

function redirectAdmin() {
    router.push({ name: 'admin' })
}

async function handleLogout() {
    await store.logout()
    await router.push({ name: 'login' })
}
const isActive = (item) => route.name === item.to?.name

const isVisible = ref(true)
const lastScrollY = ref(window.scrollY || 0)

function handleScroll() {
    const currentY = window.scrollY || 0

    if (currentY < 50) {
        isVisible.value = true
    } else {
        if (currentY > lastScrollY.value) {
            isVisible.value = false
        } else {
            isVisible.value = true
        }
    }

    lastScrollY.value = currentY
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true })
})

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>
