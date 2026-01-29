<template>
    <div class="mt-1 mb-10 overflow-x-hidden md:mt-10">
        <div class="relative right-1/2 left-1/2 -mx-[50vw] w-screen">
            <div class="mx-auto max-w-11/12 sm:max-w-10/12">
                <section class="w-full">
                    <div
                        class="bg-rosegold-100/60 mb-3 flex flex-col items-start justify-center gap-1 rounded-xl border border-gray-300 p-4 sm:mb-6 md:gap-3 md:p-6"
                    >
                        <p class="font-serif text-lg text-gray-600 md:text-xl">
                            Numărul comenzii:
                        </p>
                        <p
                            class="text-rosegold-700 font-serif text-xl font-bold md:text-3xl"
                        >
                            {{ order?.order_number }}
                        </p>
                    </div>
                    <div
                        class="mb-3 grid grid-cols-1 gap-3 sm:mb-6 sm:gap-6 xl:grid-cols-[3fr_2fr]"
                    >
                        <div>
                            <div
                                class="mb-3 flex flex-col self-start rounded-xl border border-gray-300 bg-[rgba(204,204,204,0.2)] p-4 sm:mb-6 md:p-6"
                            >
                                <div class="flex gap-3">
                                    <Truck class="text-rosegold-700 h-7 w-7" />
                                    <span
                                        class="font-serif text-xl font-semibold text-gray-800"
                                        >Detalii livrare</span
                                    >
                                </div>
                                <div
                                    class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2"
                                >
                                    <div class="space-y-6">
                                        <div class="flex gap-3">
                                            <div class="flex justify-center">
                                                <CalendarDays
                                                    class="text-rosegold-700 h-6 w-6"
                                                />
                                            </div>
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-serif text-lg text-gray-600"
                                                    >Data livrării</span
                                                >
                                                <span
                                                    class="font-serif text-lg font-semibold"
                                                    >{{
                                                        formatDate(
                                                            order?.delivery_date,
                                                        )
                                                    }}</span
                                                >
                                            </div>
                                        </div>
                                        <div class="flex gap-3">
                                            <div class="flex justify-center">
                                                <MapPin
                                                    class="text-rosegold-700 h-6 w-6"
                                                />
                                            </div>
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-serif text-lg text-gray-600"
                                                    >Adresă de livrare:</span
                                                >
                                                <span
                                                    class="font-serif text-lg font-semibold"
                                                    >{{
                                                        order?.details?.address
                                                    }}</span
                                                >
                                                <span
                                                    class="font-serif text-lg text-gray-600"
                                                    >{{
                                                        order?.details?.state
                                                    }},
                                                    {{ order?.details?.city }},
                                                    {{
                                                        order?.details?.zipcode
                                                    }}</span
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-6">
                                        <div class="flex gap-3">
                                            <div class="flex justify-center">
                                                <Phone
                                                    class="text-rosegold-700 h-6 w-6"
                                                />
                                            </div>
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-serif text-lg text-gray-600"
                                                    >Telefon contact:</span
                                                >
                                                <span
                                                    class="font-serif text-lg font-semibold"
                                                    >{{
                                                        formatPhone(
                                                            order?.details
                                                                ?.phone_number,
                                                        )
                                                    }}</span
                                                >
                                            </div>
                                        </div>
                                        <div class="flex gap-3">
                                            <div class="flex justify-center">
                                                <CreditCard
                                                    class="text-rosegold-700 h-6 w-6"
                                                />
                                            </div>
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-serif text-lg text-gray-600"
                                                    >Metodă de plată:</span
                                                >
                                                <span
                                                    class="font-serif text-lg font-semibold"
                                                    >{{ paymentLabel }}</span
                                                >
                                                <div
                                                    :class="
                                                        paymentStatusUI.class
                                                    "
                                                    class="mt-1 inline-flex w-fit items-center rounded-full border px-3 py-0.5 text-sm font-semibold"
                                                >
                                                    {{ paymentStatusUI.label }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mb-3 flex flex-col self-start rounded-xl border border-gray-300 bg-[rgba(204,204,204,0.2)] p-4 sm:mb-6 md:p-6"
                            >
                                <div class="mb-5 flex gap-3">
                                    <Package
                                        class="text-rosegold-700 h-7 w-7"
                                    />
                                    <span
                                        class="font-serif text-xl font-semibold text-gray-800"
                                        >Stadiu comandă</span
                                    >
                                </div>

                                <div class="ml-1 space-y-1">
                                    <div
                                        v-for="(step, index) in timeline"
                                        :key="step.key"
                                        class="flex gap-4"
                                    >
                                        <div class="flex flex-col items-center">
                                            <div
                                                :class="{
                                                    'bg-rosegold-700':
                                                        step.completed,
                                                    'bg-rosegold-500 ring-rosegold-300 ring-4':
                                                        step.current,
                                                    'border border-gray-400 bg-gray-300':
                                                        !step.completed &&
                                                        !step.current,
                                                }"
                                                class="flex h-4 w-4 items-center justify-center rounded-full"
                                            >
                                                <CircleCheckBig
                                                    v-if="step.completed"
                                                    class="h-3 w-3 text-white"
                                                />
                                            </div>

                                            <div
                                                v-if="
                                                    index < timeline.length - 1
                                                "
                                                :class="
                                                    step.completed
                                                        ? 'bg-rosegold-700'
                                                        : 'bg-gray-300'
                                                "
                                                class="h-15 w-0.5"
                                            />
                                        </div>

                                        <div class="-mt-1.5 pb-8">
                                            <p
                                                :class="
                                                    step.completed ||
                                                    step.current
                                                        ? 'text-gray-900'
                                                        : 'text-gray-400'
                                                "
                                                class="font-serif text-lg font-semibold"
                                            >
                                                {{ step.label }}
                                            </p>

                                            <p class="text-base text-gray-500">
                                                {{
                                                    step.date
                                                        ? formatDateTime(
                                                              step.date,
                                                          )
                                                        : 'În așteptare'
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mb-3 flex flex-col self-start rounded-xl border border-gray-300 bg-[rgba(204,204,204,0.2)] p-4 sm:mb-6 md:p-6"
                            >
                                <div class="mb-5 flex gap-3">
                                    <ShoppingBasket
                                        class="text-rosegold-700 h-7 w-7"
                                    />
                                    <span
                                        class="font-serif text-xl font-semibold text-gray-800"
                                        >Produse comandate</span
                                    >
                                </div>

                                <div class="space-y-4">
                                    <div
                                        v-for="item in order?.items || []"
                                        :key="item.id"
                                        class="flex flex-col rounded-lg bg-white/40 p-4"
                                    >
                                        <div class="flex gap-4">
                                            <div
                                                v-if="
                                                    item?.product?.media?.[0]
                                                        ?.full_url
                                                "
                                                class="relative h-20 w-20 shrink-0 overflow-hidden rounded-lg bg-[rgba(204,204,204,0.2)]"
                                            >
                                                <img
                                                    :src="
                                                        item?.product
                                                            ?.media?.[0]
                                                            ?.full_url
                                                    "
                                                />
                                            </div>
                                            <div
                                                v-else
                                                class="relative h-20 w-20 shrink-0 overflow-hidden rounded-lg bg-[rgba(204,204,204,0.2)]"
                                            >
                                                <ImageOff
                                                    class="h-20 w-20 text-gray-400"
                                                />
                                            </div>

                                            <div class="min-w-0 flex-1">
                                                <p
                                                    class="line-clamp-2 font-serif text-lg font-semibold text-gray-800"
                                                >
                                                    {{ item?.product?.title }}
                                                </p>
                                                <span
                                                    v-if="item?.product?.badge"
                                                    class="border-rosegold-500 text-rosegold-900 bg-rosegold-100/20 mt-1 inline-flex w-fit rounded-full border px-1 font-serif"
                                                >
                                                    {{ item?.product?.badge }}
                                                </span>
                                                <div
                                                    class="mt-1 flex items-center gap-2"
                                                >
                                                    <span
                                                        class="font-serif text-base text-gray-600"
                                                    >
                                                        Cantitate:
                                                        {{ item.quantity }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="shrink-0 text-right">
                                                <p
                                                    class="text-rosegold-700 font-serif text-lg font-semibold"
                                                >
                                                    {{
                                                        money(
                                                            item?.unit_price *
                                                                item?.quantity,
                                                        )
                                                    }}
                                                    RON
                                                </p>

                                                <p
                                                    v-if="item.quantity > 1"
                                                    class="font-serif text-base text-gray-500"
                                                >
                                                    {{ money(item.unit_price) }}
                                                    RON / buc
                                                </p>
                                            </div>
                                        </div>

                                        <div
                                            v-if="
                                                item?.addons &&
                                                item.addons.length > 0
                                            "
                                            class="mt-1 border-t border-gray-300 pt-1 font-serif text-[16px] lg:text-xl"
                                        >
                                            <div
                                                v-for="addon in item?.addons"
                                                :key="addon.id"
                                                class="mt-1 flex items-center gap-3"
                                            >
                                                <!--panglica-->
                                                <div
                                                    v-if="
                                                        addon.value?.key ===
                                                        'ribbon'
                                                    "
                                                    class="flex w-full items-center justify-between gap-1"
                                                >
                                                    <div
                                                        class="flex items-center gap-1"
                                                    >
                                                        <RibbonIcon
                                                            class="text-rosegold-900 h-4 w-4 lg:h-5 lg:w-5"
                                                        />
                                                        <span
                                                            class="text-center"
                                                        >
                                                            {{
                                                                addon.value
                                                                    ?.text
                                                            }}
                                                        </span>
                                                    </div>
                                                    <p
                                                        class="text-rosegold-700 text-right font-serif text-lg font-semibold"
                                                    >
                                                        {{ money(addon.price) }}
                                                        RON
                                                    </p>
                                                </div>

                                                <!--sclipici-->
                                                <div
                                                    v-if="
                                                        addon.value?.key ===
                                                            'glitters' ||
                                                        addon.value?.key ===
                                                            'glitter'
                                                    "
                                                    class="flex w-full items-center justify-between gap-1"
                                                >
                                                    <div
                                                        class="flex items-center gap-1"
                                                    >
                                                        <SparklesIcon
                                                            class="text-rosegold-900 h-4 w-4 lg:h-5 lg:w-5"
                                                        />
                                                        <div
                                                            :style="{
                                                                backgroundColor:
                                                                    addon.value
                                                                        .hex_code,
                                                            }"
                                                            class="h-4 w-4 rounded lg:h-5 lg:w-5"
                                                        ></div>
                                                    </div>
                                                    <p
                                                        class="text-rosegold-700 text-right font-serif text-lg font-semibold"
                                                    >
                                                        {{ money(addon.price) }}
                                                        RON
                                                    </p>
                                                </div>

                                                <!--led-->
                                                <div
                                                    v-if="
                                                        addon.value?.key ===
                                                        'led'
                                                    "
                                                    class="flex w-full items-center justify-between gap-1"
                                                >
                                                    <div
                                                        class="flex items-center gap-1"
                                                    >
                                                        <SirenIcon
                                                            class="text-rosegold-900 h-4 w-4 lg:h-5 lg:w-5"
                                                        />
                                                    </div>
                                                    <p
                                                        class="text-rosegold-700 text-right font-serif text-lg font-semibold"
                                                    >
                                                        {{ money(addon.price) }}
                                                        RON
                                                    </p>
                                                </div>
                                            </div>
                                            <!--photos-->
                                            <div
                                                v-if="
                                                    photoCountForItem(item) > 0
                                                "
                                                class="flex w-full items-center justify-between gap-1"
                                            >
                                                <div
                                                    class="flex items-center gap-1"
                                                >
                                                    <ImageIcon
                                                        class="text-rosegold-900 h-4 w-4 lg:h-5 lg:w-5"
                                                    /><span class="text-center">
                                                        {{
                                                            photoCountForItem(
                                                                item,
                                                            )
                                                        }}
                                                    </span>
                                                </div>
                                                <p
                                                    class="text-rosegold-700 text-right font-serif text-lg font-semibold"
                                                >
                                                    {{
                                                        money(
                                                            photoTotalForItem(
                                                                item,
                                                            ),
                                                        )
                                                    }}
                                                    RON
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div
                                class="mb-3 flex self-start rounded-xl border border-gray-300 bg-[rgba(204,204,204,0.2)] p-4 sm:mb-6 md:p-6"
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
                                            Subtotal produse
                                        </span>
                                        <span
                                            class="font-serif text-[17px] font-semibold lg:text-xl"
                                        >
                                            {{ order?.subtotal }} RON
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
                                            v-if="order?.transport === 0"
                                            class="font-serif text-[17px] font-semibold text-green-600 lg:text-xl"
                                        >
                                            GRATIS
                                        </span>
                                        <span
                                            v-else
                                            class="font-serif text-[17px] font-semibold lg:text-xl"
                                        >
                                            {{ order?.transport }} RON
                                        </span>
                                    </div>

                                    <div
                                        v-if="order?.discount > 0"
                                        class="flex items-center justify-between gap-2 px-2"
                                    >
                                        <span
                                            class="flex-1 font-serif text-[17px] lg:text-xl"
                                        >
                                            Discount
                                            <span class="font-semibold">{{
                                                order?.coupon_code
                                            }}</span>
                                        </span>
                                        <span
                                            class="font-serif text-[17px] font-semibold text-green-600 lg:text-xl"
                                        >
                                            - {{ order?.discount }} RON
                                        </span>
                                    </div>

                                    <div
                                        class="mt-2 flex w-full justify-between rounded-lg bg-[rgba(168,168,168,0.2)] p-2 font-semibold"
                                    >
                                        <span
                                            class="font-serif text-lg lg:text-xl"
                                        >
                                            Total comandă:
                                        </span>
                                        <span
                                            class="font-serif text-lg lg:text-xl"
                                        >
                                            {{ order?.total_price }} RON
                                        </span>
                                    </div>

                                    <div
                                        :class="paymentStatusUI.class"
                                        class="mt-3 flex w-full items-center rounded-xl border px-3 py-1 font-semibold transition-colors"
                                        style="border-radius: 10px"
                                    >
                                        <component
                                            :is="paymentStatusUI.icon"
                                            v-if="paymentStatusUI.icon"
                                            class="mr-2 h-5 w-5"
                                        />
                                        <span
                                            class="font-serif text-lg lg:text-xl"
                                        >
                                            {{ paymentStatusUI.label }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mb-3 flex self-start rounded-xl border border-gray-300 bg-[rgba(204,204,204,0.2)] p-4 sm:mb-6 md:p-6"
                            >
                                <div class="flex items-start gap-4">
                                    <Mail
                                        class="text-rosegold-700 mt-1 h-5 w-5 shrink-0"
                                    />
                                    <div class="flex flex-col">
                                        <span
                                            class="font-serif text-lg font-semibold lg:text-xl"
                                            >Verifică-ți mail-ul</span
                                        >
                                        <span
                                            class="font-serif text-base lg:text-lg"
                                            >Am trimis confirmarea comenzii și
                                            detaliile de livrare la
                                            <span
                                                class="font-semibold break-all text-gray-900"
                                            >
                                                {{ order?.details?.email }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mb-3 flex self-start rounded-xl border border-gray-300 bg-[rgba(204,204,204,0.2)] p-4 sm:mb-6 md:p-6"
                            >
                                <div class="flex w-full gap-4">
                                    <div class="flex w-full flex-col gap-3">
                                        <span
                                            class="mb-3 font-serif text-lg font-semibold lg:text-xl"
                                            >Ce poți face acum?</span
                                        >
                                        <button
                                            class="hover:bg-rosegold-500 group flex w-full items-center justify-center border border-gray-300 px-4 py-2 transition-colors"
                                            style="border-radius: 10px"
                                            @click="redirectHome"
                                        >
                                            <span
                                                class="flex items-center gap-2 font-sans text-[16px] text-gray-900 group-hover:text-white lg:text-lg"
                                            >
                                                <House
                                                    class="mr-2 h-5 w-5 lg:h-6 lg:w-6"
                                                />
                                                Continuă cumpărăturile
                                                <ChevronRight
                                                    class="ml-2 h-5 w-5 lg:h-6 lg:w-6"
                                                />
                                            </span>
                                        </button>

                                        <button
                                            class="bg-rosegold-500 hover:bg-rosegold-300 group flex w-full items-center justify-center border border-gray-300 px-4 py-2 transition-colors"
                                            style="border-radius: 10px"
                                            @click="redirectOrders"
                                        >
                                            <span
                                                class="flex items-center gap-2 font-sans text-[16px] text-white group-hover:text-gray-600 lg:text-lg"
                                            >
                                                <ChevronLeft
                                                    class="mr-2 h-5 w-5 lg:h-6 lg:w-6"
                                                />
                                                Vezi comenzile tale
                                                <Package
                                                    class="ml-2 h-5 w-5 lg:h-6 lg:w-6"
                                                />
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mb-3 flex self-start rounded-xl border border-gray-300 bg-[rgba(204,204,204,0.2)] p-4 sm:mb-6 md:p-6"
                            >
                                <div class="flex w-full items-start gap-4">
                                    <MessageCircleQuestionMark
                                        class="text-rosegold-700 mt-1 h-5 w-5 shrink-0"
                                    />
                                    <div
                                        class="flex w-full flex-col gap-2 md:flex-row md:items-center md:justify-between md:gap-10"
                                    >
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="font-serif text-lg font-semibold lg:text-xl"
                                                >Ai nevoie de ajutor?</span
                                            >
                                            <span
                                                class="font-serif text-base lg:text-lg"
                                                >Echipa noastră îți stă la
                                                dispoziție 24/7.
                                            </span>
                                        </div>
                                        <div>
                                            <button
                                                class="hover:bg-rosegold-500 group flex w-full items-center justify-center border border-gray-300 px-4 py-2 transition-colors"
                                                style="border-radius: 10px"
                                                @click="openWhatsApp"
                                            >
                                                <span
                                                    class="flex items-center gap-2 font-sans text-sm text-gray-900 group-hover:text-white lg:text-[16px]"
                                                >
                                                    <Send
                                                        class="mr-2 h-4 w-4 shrink-0 lg:h-5 lg:w-5"
                                                    />
                                                    Trimite-ne un mesaj pe
                                                    WhatsApp
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useFieldErrors } from '../utils/useFieldErrors.js'
import axiosClient from '../js/axios.js'
import { useAppStore } from '../store/index.js'
import { useToast } from '../utils/myToast.js'
import {
    BadgeCheck,
    Ban,
    CalendarDays,
    ChevronLeft,
    ChevronRight,
    CircleCheckBig,
    CircleX,
    Clock,
    CreditCard,
    House,
    ImageIcon,
    ImageOff,
    Mail,
    MapPin,
    MessageCircleQuestionMark,
    Package,
    Phone,
    RibbonIcon,
    Send,
    ShoppingBasket,
    SirenIcon,
    SparklesIcon,
    Truck,
} from 'lucide-vue-next'

const store = useAppStore()
const route = useRoute()
const router = useRouter()

const { showToast } = useToast()

const order = ref(null)
const loading = ref(false)
const { formErrors, generalError, handleApiError } = useFieldErrors()

const photoCountForItem = (item) =>
    (item.addons || []).filter((a) => a.value?.key === 'photo').length

const photoTotalForItem = (item) =>
    (item.addons || [])
        .filter((a) => a.value?.key === 'photo')
        .reduce((sum, a) => sum + Number(a.price || 0), 0)

const paymentLabel = computed(() => {
    switch (order.value?.payment_method) {
        case 'card':
            return 'Card bancar'
        default:
            return '—'
    }
})

const paymentStatusConfig = {
    confirmed: {
        label: 'Plată confirmată',
        icon: BadgeCheck,
        class: 'bg-green-100 text-green-700 border-green-500',
    },
    pending: {
        label: 'Plată în curs',
        icon: Clock,
        class: 'bg-amber-100 text-amber-700 border-amber-500',
    },
    failed: {
        label: 'Plată eșuată',
        icon: CircleX,
        class: 'bg-red-100 text-red-700 border-red-500',
    },
    canceled: {
        label: 'Plată anulată',
        icon: Ban,
        class: 'bg-gray-100 text-gray-700 border-gray-300',
    },
}

const paymentStatus = computed(() => order.value?.payment_status)

const paymentStatusUI = computed(() => {
    return (
        paymentStatusConfig[paymentStatus.value] ?? {
            label: '-',
            icon: null,
            class: 'bg-gray-100 text-gray-700 border-gray-500',
        }
    )
})

const steps = [
    { key: 'pending', label: 'Comandă plasată' },
    { key: 'processing', label: 'Plată confirmată' },
    { key: 'preparing', label: 'În curs de pregătire' },
    { key: 'shipped', label: 'Predată curierului' },
    { key: 'delivered', label: 'Livrată' },
]

const timeline = computed(() => {
    const currentKey = order.value?.status
    const currentIndex = steps.findIndex((step) => step.key === currentKey)

    return steps.map((step, index) => {
        const log = order.value?.status_logs?.find((s) => s.status === step.key)

        return {
            ...step,
            completed: currentIndex !== -1 && index < currentIndex,
            current: currentIndex !== -1 && index === currentIndex,
            date: log ? log.created_at : null,
        }
    })
})

function formatDateTime(dateString) {
    const d = new Date(dateString)

    return new Intl.DateTimeFormat('ro-RO', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    }).format(d)
}

function formatPhone(phone) {
    if (!phone) return ''

    const clean = phone.replace(/[^\d+]/g, '')

    if (clean.startsWith('+40') && clean.length === 12) {
        return clean.replace(/^(\+40)(\d{3})(\d{3})(\d{3})$/, '$1 $2 $3 $4')
    }

    if (clean.startsWith('07') && clean.length === 10) {
        return clean.replace(/^(07\d{2})(\d{3})(\d{3})$/, '$1 $2 $3')
    }

    return clean.replace(/(\d{3})(?=\d)/g, '$1 ')
}

function formatDate(dateString) {
    if (!dateString) return '-'

    const d = new Date(dateString)
    if (Number.isNaN(d.getTime())) return '-'

    return new Intl.DateTimeFormat('ro-RO', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    }).format(d)
}
async function fetchOrder(orderId) {
    generalError.value = null
    loading.value = true

    try {
        const res = await axiosClient.get(`/orders/${orderId}`)
        order.value = res.data
    } catch (err) {
        handleApiError(err)
    } finally {
        loading.value = false
    }
}

onMounted(async () => {
    await fetchOrder(route.params.orderId)

    if (order?.value?.created_by !== store.user.data.id) {
        showToast('Nu poți accesa această resursă!', 'error')
        await router.push({ name: 'app.home' })
    }
})

function redirectHome() {
    router.push({ name: 'app.home' })
}

function redirectOrders() {
    router.push({ name: 'profile.orders' })
}

function openWhatsApp() {
    const phone = '40767754040'
    const message = encodeURIComponent('Bună! Am nevoie de ajutor!')
    window.open(`https://wa.me/${phone}?text=${message}`, '_blank')
}

function money(v) {
    const n = Number(v || 0)

    if (Number.isInteger(n)) {
        return n.toString()
    }

    return n.toFixed(2).replace(/\.00$/, '')
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
</script>
