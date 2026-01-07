<template>
    <div class="mt-1 mb-10 overflow-x-hidden sm:mt-5">
        <div class="relative right-1/2 left-1/2 -mx-[50vw] w-screen">
            <div
                class="mx-auto flex max-w-11/12 flex-col items-center justify-center bg-[#f3f3f3] sm:max-w-10/12"
            >
                <!--header-->
                <div class="w-full">
                    <div class="pb-1">
                        <p
                            class="font-serif text-2xl font-medium text-gray-900 sm:text-3xl"
                        >
                            Contul meu
                        </p>
                        <p
                            class="-translate-y-2 font-serif text-lg text-gray-600 sm:text-xl"
                        >
                            Gestionează informațiile și comenzile tale
                        </p>
                    </div>
                </div>

                <!--sidebar-->
                <div class="grid w-full grid-cols-1 gap-8 lg:grid-cols-4">
                    <aside class="lg:col-span-1">
                        <div
                            class="sticky overflow-hidden rounded-lg border-1 border-gray-200 bg-white"
                        >
                            <nav class="flex flex-col">
                                <button
                                    v-for="item in menuItems"
                                    :key="item.id"
                                    :class="
                                        activeRouteName === item.routeName
                                            ? 'bg-rosegold-700 text-white'
                                            : 'text-gray-600 hover:bg-rose-100/30'
                                    "
                                    class="flex items-center justify-between gap-3 px-4 py-2"
                                    @click="
                                        item.routeName &&
                                        router.push({ name: item.routeName })
                                    "
                                >
                                    <div class="flex items-center gap-2">
                                        <component
                                            :is="item.icon"
                                            class="h-6 w-6 lg:h-7 lg:w-7"
                                        />
                                        <span
                                            class="text font-serif text-lg font-medium lg:text-xl"
                                        >
                                            {{ item.label }}</span
                                        >
                                    </div>
                                    <ChevronRight
                                        v-if="
                                            activeRouteName === item.routeName
                                        "
                                        class="h-5 w-5 lg:h-6 lg:w-6"
                                    />
                                </button>
                            </nav>
                            <button
                                class="flex w-full items-center justify-between gap-3 px-4 py-2 text-gray-600 hover:bg-rose-100/30"
                                @click="handleLogout"
                            >
                                <div class="flex items-center gap-2">
                                    <component
                                        :is="LogOut"
                                        class="h-6 w-6 text-red-600 lg:h-7 lg:w-7"
                                    />
                                    <span
                                        class="font-serif text-lg font-medium text-red-600 lg:text-xl"
                                    >
                                        Logout</span
                                    >
                                </div>
                            </button>
                        </div>
                    </aside>

                    <main class="lg:col-span-3">
                        <div
                            class="rounded-lg border border-gray-300 bg-[rgba(204,204,204,0.2)] p-6"
                        >
                            <RouterView />
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {
    ChevronRight,
    Lock,
    LogOut,
    MapPin,
    ShoppingBag,
    User,
} from 'lucide-vue-next'
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '../store/index.js'

const route = useRoute()
const router = useRouter()
const store = useAppStore()

const activeRouteName = computed(() => route.name)
async function handleLogout() {
    await store.logout()
    await router.push({ name: 'login' })
}

const menuItems = [
    { id: 'info', label: 'Informații', icon: User, routeName: 'profile.data' },
    {
        id: 'orders',
        label: 'Comenzile mele',
        icon: ShoppingBag,
        routeName: 'profile.orders',
    },
    {
        id: 'addresses',
        label: 'Adrese livrare',
        icon: MapPin,
        routeName: 'profile.shipping-addresses',
    },
    {
        id: 'password',
        label: 'Schimbă parola',
        icon: Lock,
        routeName: 'profile.change-password',
    },
]
</script>
