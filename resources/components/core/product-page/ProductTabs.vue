<template>
    <div class="mt-6">
        <!--tab uri-->
        <div
            class="flex justify-center gap-4 border-b-1 border-gray-400 sm:gap-6"
        >
            <button
                v-for="(tab, i) in tabs"
                :key="tab.key"
                :class="[
                    activeTab === tab.key
                        ? 'border-rosegold-700 text-rosegold-700 border-b-2'
                        : 'group text-black hover:text-gray-700',
                ]"
                class="pb-2 transition-colors duration-300"
                @click="activeTab = tab.key"
            >
                <span
                    class="font-serif text-xl font-semibold transition-colors duration-300 group-hover:text-gray-600"
                    >{{ tab.label }}</span
                >
            </button>
        </div>

        <!--content tab-uri-->
        <div class="mt-6">
            <div v-if="activeTab === 'description'">
                <p class="mb-3 font-serif text-2xl font-bold sm:text-3xl">
                    Descriere
                </p>
                <div
                    v-if="
                        product?.top_parent_categories?.some(
                            (cat) => cat.name === 'Buchet',
                        )
                    "
                    class="space-y-4 text-justify indent-8 font-serif text-lg leading-relaxed sm:text-xl"
                >
                    <p>
                        Buchetele noastre îmbină eleganța atemporală cu
                        delicatețea detaliilor lucrate manual. Fiecare floare
                        este creată cu grijă din panglică de satin fin, pentru a
                        reda frumusețea și rafinamentul unui buchet natural, dar
                        fără grija ofilirii.
                    </p>
                    <p>
                        Personalizează-l după gustul tău, adaugă accente
                        sclipitoare, panglici sau lumini LED și transformă-l
                        într-o creație unică, la fel ca povestea ta.
                    </p>
                </div>
            </div>

            <div v-if="activeTab === 'info'">
                <p class="mb-3 font-serif text-2xl font-bold sm:text-3xl">
                    Informatii suplimentare
                </p>
                <div class="overflow-hidden rounded-lg border">
                    <table class="w-full">
                        <tbody>
                            <tr
                                v-for="(item, index) in additionalInfo"
                                :key="index"
                                :class="[
                                    index % 2 === 0
                                        ? 'group bg-white'
                                        : 'bg-rose-100/20',
                                ]"
                            >
                                <td
                                    class="border-b-1 border-gray-800 px-4 py-2 font-serif text-xl group-hover:bg-rose-100/20"
                                >
                                    {{ item.label }}
                                </td>
                                <td
                                    class="px-4 py-2 font-serif text-lg text-gray-600 group-hover:bg-rose-100/20"
                                >
                                    {{ item.value }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-if="activeTab === 'reviews'">
                <div class="grid grid-cols-1">
                    <div class="flex items-center gap-6">
                        <p class="font-serif text-2xl font-bold sm:text-3xl">
                            Recenzii
                        </p>
                        <div
                            class="bg-rosegold-300 flex -translate-y-1.5 items-center gap-2 rounded px-2 py-1"
                        >
                            <span
                                class="font-serif text-xl font-semibold sm:text-2xl"
                            >
                                {{ props.reviewsMeta?.average_rating }}
                            </span>
                            <Star class="text-lg" />
                        </div>
                        <p class="font-serif text-xl">
                            ( {{ props.reviewsMeta?.total_reviews }}
                            {{
                                props.reviewsMeta?.total_reviews === 1
                                    ? 'recenzie'
                                    : 'recenzii'
                            }}
                            )
                        </p>
                    </div>
                </div>

                <div class="rounded-lg border-none bg-transparent p-8">
                    <div class="flex flex-col items-center gap-6">
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-2">
                                <svg
                                    v-for="star in 5"
                                    :key="star"
                                    :class="[
                                        'h-8 w-8',
                                        star <=
                                        props.reviewsMeta?.average_rating
                                            ? 'text-rosegold-700'
                                            : 'text-gray-300',
                                    ]"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M12 .587l3.668 7.435 8.2 1.193-5.934 5.782 1.402 8.178L12 18.896l-7.336 3.86 1.402-8.178L.132 9.215l8.2-1.193z"
                                    />
                                </svg>
                            </div>
                        </div>

                        <div class="w-full max-w-2xl space-y-3">
                            <div></div>
                            <div
                                v-for="rating in props.reviewsMeta
                                    ?.rating_breakdown"
                                :key="rating.stars"
                                class="flex items-center gap-4"
                            >
                                <!--legenda-->
                                <div class="flex w-8 items-center gap-1">
                                    <span class="font-serif text-lg font-bold">
                                        {{ rating.stars }}
                                    </span>
                                    <span class="text-rosegold-700 text-lg"
                                        >★</span
                                    >
                                </div>

                                <!--harta-->
                                <div
                                    class="h-2 flex-1 overflow-hidden rounded-full bg-gray-300"
                                >
                                    <div
                                        :class="[
                                            'h-full transition-all',
                                            props.reviewsMeta?.total_reviews &&
                                            props.reviewsMeta.total_reviews > 0
                                                ? 'bg-rosegold-500'
                                                : 'bg-gray-300',
                                        ]"
                                        :style="{
                                            width:
                                                props.reviewsMeta
                                                    ?.total_reviews &&
                                                props.reviewsMeta
                                                    .total_reviews > 0
                                                    ? (rating.count /
                                                          props.reviewsMeta
                                                              .total_reviews) *
                                                          100 +
                                                      '%'
                                                    : '100%',
                                        }"
                                    ></div>
                                </div>

                                <!--numar de recenzii-->
                                <span class="font-serif text-lg font-bold">
                                    {{ rating.count }}
                                </span>
                            </div>
                        </div>

                        <Transition name="fade-slide">
                            <div
                                v-if="successMessage"
                                class="flex items-center justify-center rounded-lg bg-green-100 px-3 py-2 text-green-800 shadow-md"
                            >
                                <span class="font-serif text-lg">{{
                                    successMessage
                                }}</span>
                            </div>
                        </Transition>

                        <button
                            v-if="isLoggedIn"
                            ref="reviewButtonRef"
                            :style="{ borderRadius: '12px' }"
                            class="bg-rosegold-500 hover:bg-rosegold-700 group flex items-center justify-center gap-2 px-4 py-2"
                            @click="toggleReviewForm"
                        >
                            <span class="text-lg font-medium text-white"
                                >Scrie un review</span
                            >
                            <CircleStar
                                class="group-hover:text-rosegold-900 text-lg font-medium text-white"
                                size="28"
                            />
                        </button>

                        <p
                            v-else
                            class="mt-2 font-serif text-lg text-gray-600 italic"
                        >
                            Trebuie să fii autentificat(ă) pentru a scrie o
                            recenzie.
                        </p>

                        <!--review form-->
                        <Transition name="fade-slide">
                            <div
                                v-if="showReviewForm"
                                ref="reviewFormRef"
                                class="mt-3 w-full max-w-xl rounded-lg"
                            >
                                <div class="mb-4 flex justify-center gap-2">
                                    <button
                                        v-for="star in 5"
                                        :key="star"
                                        class="transition-transform duration-150 hover:scale-110"
                                        type="button"
                                        @click="form.rating = star"
                                    >
                                        <svg
                                            :class="[
                                                'h-8 w-8 cursor-pointer',
                                                star <= form.rating
                                                    ? 'text-rosegold-700'
                                                    : 'hover:text-rosegold-300 text-gray-300',
                                            ]"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M12 .587l3.668 7.435 8.2 1.193-5.934 5.782 1.402 8.178L12 18.896l-7.336 3.86 1.402-8.178L.132 9.215l8.2-1.193z"
                                            />
                                        </svg>
                                    </button>
                                </div>
                                <div
                                    class="flex flex-col items-center space-y-3"
                                >
                                    <MyInput
                                        v-model="form.email"
                                        class="w-full"
                                        label="* Email"
                                    />
                                    <MyInput
                                        v-model="form.order_id"
                                        class="w-full"
                                        label="* ID comanda"
                                    />
                                    <MyInput
                                        v-model="form.text"
                                        class="w-full"
                                        label="* Review (scrie aici parerea ta)"
                                        type="textarea"
                                    />
                                    <ErrorAlert
                                        :message="errorMessage"
                                        :message2="generalError"
                                    />

                                    <button
                                        :class="[
                                            loadingSubmitReview
                                                ? 'cursor-not-allowed opacity-50'
                                                : '',
                                        ]"
                                        :disabled="loadingSubmitReview"
                                        :style="{ borderRadius: '12px' }"
                                        class="bg-rosegold-500 hover:bg-rosegold-700 group flex items-center justify-center gap-2 px-4 py-2"
                                        @click="submitReview"
                                    >
                                        <span
                                            class="text-lg font-medium text-white"
                                            >{{
                                                loadingSubmitReview
                                                    ? 'Se trimite...'
                                                    : 'Trimite'
                                            }}</span
                                        >
                                    </button>
                                </div>
                            </div>
                        </Transition>

                        <!--recenzii-->
                        <Spinner v-if="loadingReviews" />
                        <div v-else class="w-full max-w-2xl space-y-6">
                            <div
                                v-for="(review, i) in props.reviews"
                                :key="review.id"
                                class="space-y-4 rounded-lg border p-6"
                            >
                                <div
                                    class="flex flex-col items-start justify-between sm:flex-row"
                                >
                                    <div class="flex gap-2">
                                        <p
                                            class="font-serif text-base font-semibold sm:text-lg"
                                        >
                                            {{
                                                review.author.last_name +
                                                ' ' +
                                                review.author.first_name
                                            }}
                                            <span
                                                v-if="review.is_buyer_verified"
                                                class="font-serif font-light"
                                                >(cumparator verificat)</span
                                            >
                                        </p>
                                        <span
                                            class="font-serif text-base font-semibold sm:text-lg"
                                            >|</span
                                        >
                                        <p
                                            class="font-serif text-base sm:text-lg"
                                        >
                                            {{ review.created_at }}
                                        </p>
                                    </div>
                                    <div class="flex items-center">
                                        <Star
                                            v-for="star in 5"
                                            :key="star"
                                            :class="[
                                                'fill-current',
                                                star <= review.rating
                                                    ? 'text-rosegold-700'
                                                    : 'text-gray-300',
                                            ]"
                                        />
                                    </div>
                                </div>

                                <p
                                    class="text-justify font-serif text-base leading-relaxed sm:text-lg"
                                >
                                    {{ review.text }}
                                </p>

                                <div
                                    v-if="review.reply"
                                    class="border-rosegold-500 mt-4 ml-8 space-y-2 border-l-2 pl-6"
                                >
                                    <div class="flex items-center gap-2">
                                        <CornerLeftUp
                                            class="text-gray-500/90"
                                        />
                                        <span
                                            class="font-serif text-lg font-semibold"
                                            >Echipa Satin & Sweets</span
                                        >
                                        <span
                                            class="font-serif text-lg font-semibold"
                                            >|</span
                                        >
                                        <span class="font-serif text-lg">
                                            {{ review.reply.created_at }}
                                        </span>
                                    </div>
                                    <p
                                        class="text-justify font-serif text-lg leading-relaxed"
                                    >
                                        {{ review.reply.text }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 flex items-center justify-center">
                                <button
                                    v-if="props.nextPageUrl"
                                    class=""
                                    @click="
                                        emit(
                                            'load-more-reviews',
                                            props.nextPageUrl,
                                        )
                                    "
                                >
                                    <span
                                        class="inline-block pb-1 font-serif text-lg font-semibold hover:border-b-2 hover:border-black"
                                        >Vezi mai multe</span
                                    >
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, nextTick, ref } from 'vue'
import { CircleStar, CornerLeftUp, Star } from 'lucide-vue-next'
import MyInput from '../MyInput.vue'
import { useAppStore } from '../../../store/index.js'
import { useFieldErrors } from '../../../utils/useFieldErrors.js'
import ErrorAlert from '../ErrorAlert.vue'
import Spinner from '../Spinner.vue'

const props = defineProps({
    product: {
        type: Object,
        default: () => null,
    },
    reviews: {
        type: Array,
        default: () => [],
    },
    reviewsMeta: {
        type: Object,
        default: () => ({
            average_rating: 0,
            total_reviews: 0,
            rating_breakdown: [],
        }),
    },
    nextPageUrl: {
        type: String,
        default: null,
    },
    loadingReviews: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['review-submitted', 'load-more-reviews'])

const store = useAppStore()

const isLoggedIn = computed(() => !!store.user?.token)

const additionalInfo = computed(() => {
    let dynamicInfo = []
    if (!props.product?.additional_info) {
        dynamicInfo.push({
            label: 'Cod produs',
            value: `SS-${props.product.id.toString().padStart(4, '0')}`,
        })
        return dynamicInfo
    }

    dynamicInfo = Object.entries(props.product.additional_info).map(
        ([key, value]) => ({
            label: key,
            value: value,
        }),
    )
    dynamicInfo.push({
        label: 'Cod produs',
        value: `SS-${props.product.id.toString().padStart(4, '0')}`,
    })

    return dynamicInfo
})

const form = ref({
    rating: 1,
    email: '',
    text: '',
    order_id: '',
})

const tabs = [
    {
        key: 'description',
        label: 'Descriere',
    },
    { key: 'info', label: 'Informatii suplimentare' },
    {
        key: 'reviews',
        label: 'Recenzii',
    },
]

const activeTab = ref('description')
const showReviewForm = ref(false)
const errorMessage = ref('')
const successMessage = ref('')
const reviewFormRef = ref(null)
const reviewButtonRef = ref(null)
const loadingSubmitReview = ref(false)

const { formErrors, generalError, handleApiError } = useFieldErrors()
async function submitReview() {
    if (!form.value.email || !form.value.order_id || !form.value.text) {
        errorMessage.value = 'Te rugam sa completezi toate campurile!'
        return
    }

    loadingSubmitReview.value = true

    try {
        const payload = {
            rating: form.value.rating,
            user_email: form.value.email,
            text: form.value.text,
            user_order_id: form.value.order_id,
        }

        await store.submitReview(payload, props.product?.id)

        successMessage.value = 'Mulțumim pentru recenzie! ❤️'

        emit('review-submitted')

        form.value = { rating: 1, email: '', text: '', order_id: '' }
        errorMessage.value = ''
        showReviewForm.value = false

        setTimeout(() => {
            successMessage.value = ''
        }, 6000)
    } catch (error) {
        handleApiError(error)
    } finally {
        loadingSubmitReview.value = false
    }
}

function toggleReviewForm() {
    showReviewForm.value = !showReviewForm.value

    if (showReviewForm.value) {
        nextTick(() => {
            reviewFormRef.value?.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
            })
        }, 200)
    } else {
        nextTick(() => {
            reviewButtonRef.value?.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
            })
        }, 200)
    }
}
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.35s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(10px);
}
</style>
