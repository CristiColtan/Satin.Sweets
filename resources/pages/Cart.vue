<template>
    <div class="mt-1 mb-10 overflow-x-hidden">
        <div class="relative right-1/2 left-1/2 -mx-[50vw] w-screen">
            <div class="mx-auto max-w-11/12 sm:max-w-10/12">
                <section class="w-full">
                    <CheckoutSteps :current-step="1" />
                    <div class="gap-12 bg-[#f3f3f3]">
                        <div
                            v-if="cartItemsCount > 0"
                            class="grid grid-cols-1 gap-5 xl:grid-cols-[3fr_1fr]"
                        >
                            <div class="flex flex-col gap-3">
                                <div
                                    v-for="(product, i) in store.cart.items"
                                    :key="i"
                                    class="rounded-xl bg-[rgba(204,204,204,0.2)] p-2 md:p-3"
                                >
                                    <div
                                        class="mb-1 flex justify-between gap-1 pb-1"
                                    >
                                        <div class="flex gap-3">
                                            <RouterLink
                                                :to="`/produs/${product.product.slug}`"
                                                class="bg-muted flex aspect-square h-24 w-24 rounded-2xl md:h-32 md:w-32"
                                            >
                                                <img
                                                    v-if="
                                                        (Array.isArray(
                                                            product.product
                                                                .media,
                                                        ) &&
                                                            product.product
                                                                .media.length >
                                                                0 &&
                                                            product.product
                                                                .media[0]
                                                                .full_url) ||
                                                        (Array.isArray(
                                                            product.product
                                                                .images,
                                                        ) &&
                                                            product.product
                                                                .images.length >
                                                                0 &&
                                                            product.product
                                                                .images[0].url)
                                                    "
                                                    :alt="
                                                        product.product
                                                            .media?.[0]
                                                            ?.alt_text ||
                                                        product.product
                                                            .images?.[0]
                                                            ?.alt_text ||
                                                        product.product.title
                                                    "
                                                    :src="
                                                        product.product
                                                            .media?.[0]
                                                            ?.full_url ||
                                                        product.product
                                                            .images?.[0]?.url
                                                    "
                                                    alt="Product Image"
                                                    class="h-full w-full rounded-2xl object-cover"
                                                />
                                                <div
                                                    v-else
                                                    class="flex h-full w-full items-center justify-center bg-gray-100 text-gray-400"
                                                >
                                                    <ImageOff
                                                        class="h-24 w-24 md:h-32 md:w-32"
                                                    />
                                                </div>
                                            </RouterLink>

                                            <div
                                                class="flex flex-col items-start justify-between"
                                            >
                                                <RouterLink
                                                    :to="`/produs/${product.product.slug}`"
                                                    class="line-clamp-3 font-serif text-[17px] font-medium !text-gray-900 visited:text-gray-900 lg:text-2xl"
                                                >
                                                    {{ product.product.title }}
                                                </RouterLink>

                                                <div
                                                    class="flex items-center gap-3 rounded-lg border-1 border-gray-400/90 bg-[#f3f3f3] p-0.5 px-1"
                                                >
                                                    <button
                                                        aria-label="Scade cantitatea"
                                                        @click="
                                                            updateQuantity(
                                                                i,
                                                                product.quantity -
                                                                    1,
                                                            )
                                                        "
                                                    >
                                                        <Minus
                                                            class="flex h-4 w-4 items-center justify-center rounded transition-colors hover:bg-white lg:h-6 lg:w-6"
                                                        />
                                                    </button>
                                                    <span
                                                        class="text-center text-lg font-medium lg:text-xl"
                                                    >
                                                        {{ product.quantity }}
                                                    </span>
                                                    <button
                                                        aria-label="Crește cantitatea"
                                                        @click="
                                                            updateQuantity(
                                                                i,
                                                                product.quantity +
                                                                    1,
                                                            )
                                                        "
                                                    >
                                                        <Plus
                                                            class="flex h-4 w-4 items-center justify-center rounded transition-colors hover:bg-white lg:h-6 lg:w-6"
                                                        />
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="flex flex-shrink-0 flex-col items-end justify-between gap-1 whitespace-nowrap"
                                        >
                                            <div class="flex gap-1">
                                                <Trash2Icon
                                                    class="h-5 w-5 cursor-pointer transition-colors duration-200 hover:text-red-500 lg:h-7 lg:w-7"
                                                    @click="
                                                        store.removeFromCart(i)
                                                    "
                                                />
                                            </div>
                                            <div
                                                class="flex flex-col items-end"
                                            >
                                                <span
                                                    v-if="product.quantity > 0"
                                                    class="font-serif text-sm text-gray-500 lg:text-lg"
                                                >
                                                    {{ product.unit_price }} RON
                                                    / buc
                                                </span>
                                                <span
                                                    class="text-rosegold-900 font-serif text-lg font-medium lg:text-2xl"
                                                >
                                                    {{
                                                        product.quantity *
                                                        product.unit_price
                                                    }}
                                                    RON
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        v-if="hasAnyAddon(product.addons)"
                                        class="border-t border-gray-500 pt-1 font-serif text-[16px] lg:text-xl"
                                    >
                                        <div class="flex gap-3">
                                            <!--panglica-->
                                            <div
                                                v-if="product.addons.ribbonText"
                                                class="flex items-center gap-1"
                                            >
                                                <RibbonIcon
                                                    class="text-rosegold-900 h-5 w-5 lg:h-6 lg:w-6"
                                                />
                                                <span class="text-center">
                                                    {{
                                                        product.addons
                                                            .ribbonText
                                                    }}
                                                </span>
                                            </div>

                                            <!--sclipici-->
                                            <div
                                                v-if="product.addons.glitterId"
                                                class="flex items-center gap-1"
                                            >
                                                <SparklesIcon
                                                    class="text-rosegold-900 h-5 w-5 lg:h-6 lg:w-6"
                                                />
                                                <div
                                                    :style="{
                                                        backgroundColor:
                                                            product.addons
                                                                .glitterColor,
                                                    }"
                                                    class="h-5 w-5 rounded lg:h-6 lg:w-6"
                                                ></div>
                                            </div>

                                            <!--led-->
                                            <div
                                                v-if="product.addons.led"
                                                class="flex items-center gap-1"
                                            >
                                                <SirenIcon
                                                    class="text-rosegold-900 h-5 w-5 lg:h-6 lg:w-6"
                                                />
                                            </div>

                                            <!--led-->
                                            <div
                                                v-if="
                                                    product.addons.photoCount >
                                                    0
                                                "
                                                class="flex items-center gap-1"
                                            >
                                                <ImageIcon
                                                    class="text-rosegold-900 sm:h-5 sm:w-5 lg:h-6 lg:w-6"
                                                /><span class="text-center">
                                                    {{
                                                        product.addons
                                                            .photoCount
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    class="hover:bg-rosegold-500 group flex w-full items-center justify-center border border-gray-300 px-4 py-2 transition-colors"
                                    style="border-radius: 10px"
                                    @click="redirectHome"
                                >
                                    <span
                                        class="flex items-center gap-2 font-sans text-[16px] text-gray-900 group-hover:text-white lg:text-lg"
                                    >
                                        <ChevronLeft
                                            class="mr-2 h-5 w-5 lg:h-6 lg:w-6"
                                        />
                                        Continuă cumpărăturile</span
                                    >
                                </button>

                                <div
                                    v-if="!isAuthenticated"
                                    class="rounded bg-yellow-100 p-2 text-center font-sans text-lg text-yellow-800"
                                >
                                    Trebuie să fii autentificat pentru a
                                    continua.

                                    <button
                                        class="underline"
                                        @click="redirectLogin"
                                    >
                                        <span class="font-sans text-lg"
                                            >Click aici.</span
                                        >
                                    </button>
                                </div>
                            </div>

                            <div
                                class="flex self-start rounded-xl bg-[rgba(204,204,204,0.2)] p-3"
                            >
                                <div class="flex w-full flex-col gap-2">
                                    <p
                                        class="line-clamp-3 font-serif text-[18px] font-medium text-gray-900 lg:text-2xl"
                                    >
                                        Rezumat comandă
                                    </p>
                                    <div class="flex justify-between px-2">
                                        <span
                                            class="flex-1 font-serif text-[17px] lg:text-xl"
                                        >
                                            Produse ({{ store.cartCount }})
                                        </span>
                                        <span
                                            class="font-serif text-[17px] font-semibold lg:text-xl"
                                        >
                                            {{ store.cartTotal }} RON
                                        </span>
                                    </div>
                                    <div
                                        class="flex justify-between border-t border-gray-400 px-2 pt-2"
                                    >
                                        <span
                                            class="flex-1 font-serif text-[17px] lg:text-xl"
                                        >
                                            Transport
                                        </span>
                                        <span
                                            v-if="transport === 0"
                                            class="font-serif text-[17px] font-semibold text-green-600 lg:text-xl"
                                        >
                                            GRATIS
                                        </span>
                                        <span
                                            v-else
                                            class="font-serif text-[17px] font-semibold lg:text-xl"
                                        >
                                            {{ transport }} RON
                                        </span>
                                    </div>

                                    <div
                                        class="mt-2 flex w-full justify-between rounded-lg bg-[rgba(168,168,168,0.2)] p-2 font-semibold"
                                    >
                                        <span
                                            class="font-serif text-lg lg:text-xl"
                                        >
                                            Total:
                                        </span>
                                        <span
                                            class="font-serif text-lg lg:text-xl"
                                        >
                                            {{ total }} RON
                                        </span>
                                    </div>

                                    <button
                                        class="bg-rosegold-700 hover:bg-rosegold-500 mt-3 w-full rounded-lg border border-gray-300 py-1 font-semibold text-white transition-colors"
                                        style="border-radius: 10px"
                                        @click="redirectNextStep"
                                    >
                                        <span
                                            class="font-serif text-lg lg:text-xl"
                                        >
                                            Către plată
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            v-else
                            class="mt-16 flex flex-col items-center justify-center gap-2 pb-18 text-center md:pb-24"
                        >
                            <p class="font-serif text-xl sm:text-2xl">
                                Nu ai produse în coș.
                            </p>
                            <button @click="redirectHome">
                                <span
                                    class="text- font-serif text-lg text-gray-500 underline sm:text-xl"
                                >
                                    Click aici pentru a continua cumpărăturile!
                                </span>
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { computed } from 'vue'
import { useToast } from '../utils/myToast.js'
import { useAppStore } from '../store/index.js'
import {
    ChevronLeft,
    ImageIcon,
    ImageOff,
    Minus,
    Plus,
    RibbonIcon,
    SirenIcon,
    SparklesIcon,
    Trash2Icon,
} from 'lucide-vue-next'
import CheckoutSteps from '../components/core/checkout-page/CheckoutSteps.vue'

const store = useAppStore()
const router = useRouter()
const { showToast } = useToast()

const cartItemsCount = computed(() => store.cartCount)
const cartTotal = computed(() => store.cartTotal)
const transport = computed(() => (cartTotal.value > 300 ? 0 : 25))
const discount = computed(() => 0)

const total = computed(() => cartTotal.value + transport.value - discount.value)

function redirectHome() {
    router.push({ name: 'app.home' })
}

function redirectLogin() {
    router.push({ name: 'login' })
}

const isAuthenticated = computed(() => {
    const token = store.user.token
    return !!token
})
function redirectNextStep() {
    if (!isAuthenticated.value) {
        showToast('După autentificare vei fi redirecționat înapoi.', 'info')
    }
    router.push({ name: 'app.checkout' })
}

const isAddonSelected = (value) => {
    if (value === null || value === false) return false
    if (typeof value === 'number') return value > 0
    if (typeof value === 'string') return value.trim() !== ''
    return true
}

const hasAnyAddon = (addons) => {
    return Object.values(addons).some((v) => isAddonSelected(v))
}

function updateQuantity(id, newQuantity) {
    if (newQuantity < 1) return
    store.cart.items[id].quantity = newQuantity
}
</script>
