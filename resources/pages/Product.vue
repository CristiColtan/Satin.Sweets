<template>
    <div class="mx-auto mt-1 max-w-11/12 sm:mt-5 sm:max-w-9/12">
        <div class="border-b border-b-gray-400">
            <div class="flex items-center gap-2">
                <RouterLink class="group flex items-center" to="/">
                    <ChevronLeft
                        class="group-hover:text-rosegold-500 text-rosegold-700 h-6 w-6"
                    />
                    <span
                        class="group-hover:text-rosegold-500 text-rosegold-700 font-serif text-lg"
                        >Acasa</span
                    >
                </RouterLink>
                <span class="font-serif text-lg font-semibold text-gray-500"
                    >/</span
                >
                <span
                    class="text-rosegold-700 font-serif text-lg font-semibold"
                    >{{ product?.title }}</span
                >
            </div>
            <ErrorAlert :message="generalError" />
        </div>

        <div class="mt-4 grid items-start gap-12 lg:grid-cols-2">
            <!--left-->
            <div class="space-y-4">
                <div
                    class="bg-muted relative aspect-square overflow-hidden rounded-2xl"
                >
                    <img
                        v-if="
                            product?.images?.length &&
                            product.images[selectedImage]
                        "
                        :src="product?.images[selectedImage].url"
                        alt="Product Image"
                        class="h-full w-full object-cover"
                    />
                    <div
                        v-else
                        class="flex h-full w-full items-center justify-center bg-gray-100 text-gray-400"
                    >
                        <ImageOff class="h-36 w-36" />
                    </div>

                    <div
                        v-if="product?.badge"
                        class="bg-rosegold-700/90 absolute top-4 left-4 rounded-full px-2 py-1 text-white"
                    >
                        <span class="font-serif text-lg">{{
                            product.badge
                        }}</span>
                    </div>

                    <button
                        class="group absolute top-4 right-4 bg-white/90 p-1 shadow-lg transition-transform duration-300 hover:scale-105"
                        style="border-radius: 100px"
                        @click.stop.prevent="onToggleFavorite(product, $event)"
                    >
                        <Heart
                            :class="
                                store.isFavorite(product?.id)
                                    ? 'fill-rosegold-700 text-rosegold-700'
                                    : 'text-rosegold-700 hover:fill-rosegold-700'
                            "
                            class="h-6 w-6"
                        ></Heart>
                    </button>
                </div>

                <div
                    class="flex gap-4 rounded-xl bg-[rgba(204,204,204,0.2)] p-2"
                >
                    <button
                        v-for="(image, i) in product?.images"
                        :key="i"
                        :class="
                            selectedImage === i
                                ? 'border-rosegold-500 border-2 shadow-md'
                                : 'hover:outline-2 hover:outline-gray-300'
                        "
                        class="relative aspect-square w-24 overflow-hidden"
                        style="border-radius: 10px"
                        @click="selectedImage = i"
                    >
                        <img
                            :alt="`${product?.name} ${i + 1}`"
                            :src="image.url"
                            class="h-full w-full object-cover"
                        />
                    </button>
                </div>

                <div
                    class="flex items-center justify-center rounded-xl border-1 border-gray-300/90 py-3 text-center font-serif text-xl sm:text-2xl"
                >
                    Ai alta idee?
                    <ChevronRight class="h-8 w-8" />
                    <RouterLink class="group flex items-center" to="/">
                        <span class="hover:text-rosegold-700 text-rosegold-900">
                            Creeaza-ti propriul buchet personalizat!
                        </span>
                    </RouterLink>
                </div>

                <div
                    class="flex items-center justify-center gap-3 rounded-xl border-1 border-gray-300/90 py-3"
                >
                    <RouterLink
                        v-for="cat in product?.categories"
                        :key="cat.id ?? cat"
                        :to="`/categorie/${slugify(cat.name)}`"
                        class="bg-rosegold-500 hover:bg-rosegold-700 rounded-full px-3 py-1 text-[15px] font-medium text-white sm:text-[16px]"
                    >
                        <span class="font-serif text-lg">{{
                            typeof cat === 'string' ? cat : cat.name
                        }}</span>
                    </RouterLink>
                </div>
            </div>

            <!--right-->
            <div
                class="space-y-8 rounded-xl bg-[rgba(204,204,204,0.2)] p-3 py-4"
            >
                <div class="">
                    <p
                        class="text-muted text-center font-serif text-3xl font-semibold tracking-tight lg:text-4xl"
                    >
                        {{ product?.title }}
                    </p>
                    <div
                        class="mt-2 mb-5 flex items-center justify-center gap-4"
                    >
                        <div class="w-full border-b-1"></div>
                        <span
                            class="text-md font-serif text-nowrap text-gray-800 lg:text-lg"
                        >
                            COD Produs:
                            <span class="font-semibold"
                                >SS-{{
                                    product?.id.toString().padStart(4, '0')
                                }}</span
                            >
                        </span>
                        <div class="w-full border-b-1"></div>
                    </div>
                </div>

                <!-- step 1-->
                <div
                    v-if="
                        product?.top_parent_categories?.some(
                            (cat) => cat.name === 'Buchet',
                        )
                    "
                    class="rounded-2xl border-2 border-gray-300/90 bg-[#f3f3f3] p-3"
                >
                    <div class="mb-2 flex justify-between">
                        <div class="flex gap-3">
                            <div
                                class="bg-rosegold-500 flex h-6 w-6 items-center justify-center rounded-full font-bold text-white"
                            >
                                1
                            </div>
                            <p
                                class="-translate-y-0.5 text-center font-serif text-lg"
                            >
                                Adaugă panglică
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <p class="font-serif text-xl font-semibold">
                                +10 RON
                            </p>
                            <Check
                                v-if="ribbonText.trim()"
                                class="h-6 w-6 text-green-800 transition-all duration-300"
                            />
                        </div>
                    </div>

                    <input
                        v-model="ribbonText"
                        :style="{ fontSize: '16px' }"
                        class="focus:ring-rosegold-500 w-full rounded-lg border border-gray-300"
                        placeholder="Scrie mesajul aici..."
                        type="text"
                    />
                </div>

                <!-- step 2-->
                <div
                    v-if="
                        product?.top_parent_categories?.some(
                            (cat) => cat.name === 'Buchet',
                        )
                    "
                    class="rounded-2xl border-2 border-gray-300/90 bg-[#f3f3f3] p-3"
                >
                    <div class="mb-2 flex justify-between">
                        <div class="flex gap-3">
                            <div
                                class="bg-rosegold-500 flex h-6 w-6 items-center justify-center rounded-full font-bold text-white"
                            >
                                2
                            </div>
                            <p
                                class="-translate-y-0.5 text-center font-serif text-lg"
                            >
                                Adaugă sclipici
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <p class="font-serif text-xl font-semibold">
                                +10 RON
                            </p>
                            <Check
                                v-if="selectedGlitterId"
                                class="h-6 w-6 text-green-800 transition-all duration-300"
                            />
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="(glitter, i) in glitterAddons"
                            :key="i"
                            :class="
                                selectedGlitterId === glitter.id
                                    ? 'border-rosegold-500 border-2 shadow-md'
                                    : 'hover:outline-2 hover:outline-gray-300'
                            "
                            :style="{
                                backgroundColor: glitter.hex_code,
                                borderRadius: '10px',
                            }"
                            class="relative h-10 w-10"
                            @click="
                                selectedGlitterId =
                                    selectedGlitterId === glitter.id
                                        ? null
                                        : glitter.id
                            "
                        >
                            <Check
                                v-if="selectedGlitterId === glitter.id"
                                :class="
                                    glitter.hex_code === '#ffffff'
                                        ? 'text-black'
                                        : 'text-white'
                                "
                                class="absolute bottom-2 left-1/2 h-5 w-5 -translate-x-1/2 drop-shadow"
                            />
                        </button>
                    </div>
                </div>

                <!-- step 3-->
                <div
                    v-if="
                        product?.top_parent_categories?.some(
                            (cat) => cat.name === 'Buchet',
                        )
                    "
                    class="rounded-2xl border-2 border-gray-300/90 bg-[#f3f3f3] p-3"
                >
                    <div class="mb-2 flex justify-between">
                        <div class="flex gap-3">
                            <div
                                class="bg-rosegold-500 flex h-6 w-6 items-center justify-center rounded-full font-bold text-white"
                            >
                                3
                            </div>
                            <p
                                class="-translate-y-0.5 text-center font-serif text-lg"
                            >
                                Adaugă LED
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <p class="font-serif text-xl font-semibold">
                                +10 RON
                            </p>
                            <Check
                                v-if="ledSelected"
                                class="h-6 w-6 text-green-800 transition-all duration-300"
                            />
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button
                            :class="
                                ledSelected
                                    ? 'bg-rosegold-700'
                                    : 'bg-rosegold-500'
                            "
                            :style="{ borderRadius: '10px' }"
                            class="bg-rosegold-500 hover:bg-rosegold-700 border-2 px-2 py-1 text-white transition"
                            @click="ledSelected = !ledSelected"
                        >
                            <span class="text-lg">{{
                                ledSelected ? 'Da' : 'Nu'
                            }}</span>
                        </button>
                    </div>
                </div>

                <!-- step 4-->
                <div
                    v-if="
                        product?.top_parent_categories?.some(
                            (cat) => cat.name === 'Buchet',
                        )
                    "
                    class="rounded-2xl border-2 border-gray-300/90 bg-[#f3f3f3] p-3"
                >
                    <div class="flex justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="bg-rosegold-500 flex h-6 w-6 items-center justify-center rounded-full font-bold text-white"
                            >
                                4
                            </div>
                            <p class="text-center font-serif text-lg">
                                Adaugă poze
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <p class="font-serif text-xl font-semibold">
                                +10 RON
                            </p>
                            <Check
                                v-if="photoSelected"
                                class="h-6 w-6 text-green-800 transition-all duration-300"
                            />
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <p
                            class="font-serif text-base leading-relaxed font-semibold"
                        >
                            *pretul afișat este per poză*
                        </p>

                        <!-- PREVIEW -->
                        <div v-if="photoSelected && items.length" class="">
                            <div class="mt-2 flex flex-wrap gap-3">
                                <div
                                    v-for="(it, i) in items"
                                    :key="it.id"
                                    class="relative h-36 w-36 overflow-hidden rounded-lg border border-gray-300"
                                >
                                    <img
                                        :src="it.previewUrl"
                                        alt=""
                                        class="h-full w-full object-cover"
                                    />
                                    <div
                                        :class="
                                            it.status === 'done'
                                                ? 'bg-green-600/90'
                                                : it.status === 'uploading'
                                                  ? 'bg-black/50'
                                                  : 'bg-red-600/90'
                                        "
                                        class="absolute top-0 right-0 left-0 px-2 py-1 text-center text-xs font-semibold text-white"
                                    >
                                        <template v-if="it.status === 'done'">
                                            Încărcare completă
                                        </template>

                                        <template
                                            v-else-if="
                                                it.status === 'uploading'
                                            "
                                        >
                                            Se încarcă {{ it.progress }}%
                                        </template>

                                        <template v-else>
                                            Eroare la încărcare
                                        </template>
                                    </div>
                                    <div class="absolute top-2 left-2">
                                        <div
                                            v-if="it.status === 'uploading'"
                                            aria-label="Uploading"
                                            class="grid h-7 w-7 place-items-center rounded-full bg-black/60"
                                        >
                                            <div
                                                class="h-4 w-4 animate-spin rounded-full border-2 border-white/70 border-t-transparent"
                                            ></div>
                                        </div>
                                        <button
                                            v-else
                                            class="rounded bg-black/60 px-2 py-1 text-xs text-white hover:bg-black/80"
                                            title="Elimină din selecția nouă"
                                            type="button"
                                            @click="removeItem(i)"
                                        >
                                            ✕
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-3 flex items-center justify-between gap-3"
                        >
                            <button
                                :class="
                                    photoSelected
                                        ? 'bg-rosegold-700'
                                        : 'bg-rosegold-500'
                                "
                                :style="{ borderRadius: '10px' }"
                                class="bg-rosegold-500 hover:bg-rosegold-700 translate-y-0.5 border-2 px-2 py-1 text-white transition"
                                @click="togglePhotos"
                            >
                                <span class="text-lg">{{
                                    photoSelected ? 'Da' : 'Nu'
                                }}</span>
                            </button>
                            <div
                                v-if="photoSelected"
                                class="flex items-center gap-2 overflow-hidden"
                            >
                                <!-- real input hidden -->
                                <input
                                    ref="fileInput"
                                    accept="image/png,image/jpeg"
                                    class="hidden"
                                    multiple
                                    type="file"
                                    @change="onFilesPicked"
                                />

                                <!-- buton custom -->
                                <button
                                    class="inline-flex items-center rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-lg text-gray-600 hover:bg-gray-100"
                                    type="button"
                                    @click="fileInput.click()"
                                >
                                    Alege poze
                                </button>

                                <span class="text-sm text-gray-500">
                                    {{ items.length }}/3
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total price + cart -->
                <div class="space-y-4 rounded-2xl bg-[#f3f3f3] p-3">
                    <div class="flex items-center justify-between">
                        <span class="ml-1 font-serif text-lg text-gray-800">
                            Prețul afișat conține TVA
                        </span>
                        <div class="flex flex-col">
                            <span
                                class="text-right font-serif text-2xl font-bold md:text-3xl"
                            >
                                {{ currentPrice }} RON
                            </span>
                            <span
                                v-if="oldPrice && oldPrice !== currentPrice"
                                class="text-right font-serif text-xl text-gray-700 line-through md:text-2xl"
                            >
                                {{ oldPrice }} RON
                            </span>
                        </div>
                    </div>
                    <button
                        :disabled="isUploading"
                        :style="{ borderRadius: '12px' }"
                        class="bg-rosegold-500 hover:bg-rosegold-700 flex h-11 w-full items-center justify-center gap-2 font-medium text-white shadow-md transition"
                        @click="handleAddToCart"
                    >
                        <div class="flex items-center justify-center gap-2">
                            <ShoppingCart class="h-6 w-6" />

                            <span class="text-lg">Adaugă în coș</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <BenefitsSectionForProduct />
        <ProductTabs
            :loading-reviews="loadingReviews"
            :next-page-url="nextPageUrl"
            :product="product"
            :reviews="reviews"
            :reviews-meta="reviewsMeta"
            @load-more-reviews="fetchReviews(product.id, $event)"
            @review-submitted="handleReviewSubmitted"
        />
        <SimilarProducts
            :has-tablouri="
                product?.top_parent_categories?.[0]?.name === 'Tablou'
            "
            :products="similarProducts"
            :title="'Produse similare'"
        />
    </div>
</template>

<script setup>
import {
    computed,
    nextTick,
    onBeforeUnmount,
    onMounted,
    reactive,
    ref,
    watch,
} from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axiosClient from '../js/axios.js'

import {
    Check,
    ChevronLeft,
    ChevronRight,
    Heart,
    ImageOff,
    ShoppingCart,
} from 'lucide-vue-next'

import 'swiper/css'
import 'swiper/css/pagination'
import ProductTabs from '../components/core/product-page/ProductTabs.vue'
import BenefitsSectionForProduct from '../components/home-page/BenefitsSectionForProduct.vue'
import SimilarProducts from '../components/core/product-page/SimilarProducts.vue'
import { useFieldErrors } from '../utils/useFieldErrors.js'
import ErrorAlert from '../components/core/ErrorAlert.vue'
import { useAppStore } from '../store/index.js'
import { slugify } from '../utils/utils.js'

const route = useRoute()
const product = ref(null)
const store = useAppStore()
const router = useRouter()

const fileInput = ref(null)

const reviews = ref([])
const reviewsMeta = ref({
    average_rating: 0,
    total_reviews: 0,
    rating_breakdown: [],
})
const nextPageUrl = ref(null)

const ribbonText = ref('')
const selectedImage = ref(0)
const glitterAddons = ref([])
const selectedGlitterId = ref(null)
const ledSelected = ref(false)
const photoSelected = ref(false)
const basePrice = ref(0)
const currentPrice = computed(() => {
    let price = Number(basePrice.value)
    if (ribbonText.value.trim()) price += 10
    if (selectedGlitterId.value) price += 10
    if (ledSelected.value) price += 10
    if (photoSelected.value && items.value.length > 0) {
        price += items.value.length * 10
    }

    return price
})
const oldPrice = computed(() => {
    if (!product.value?.discounted_price) return null
    let price = Number(product.value?.price || 0)
    if (ribbonText.value.trim()) price += 10
    if (selectedGlitterId.value) price += 10
    if (ledSelected.value) price += 10
    if (photoSelected.value && items.value.length > 0) {
        price += items.value.length * 10
    }

    return price
})
const newImages = ref([])
const similarProducts = ref([])

const { formErrors, generalError, handleApiError } = useFieldErrors()
async function handleReviewSubmitted() {
    const scrollY = window.scrollY // save pos

    await fetchReviews(product.value?.id)

    // same position
    nextTick(() => {
        window.scrollTo({ top: scrollY, behavior: 'instant' })
    })
}

function removeNew(idx) {
    newImages.value.splice(idx, 1)
}

function togglePhotos() {
    photoSelected.value = !photoSelected.value

    if (!photoSelected.value) {
        for (const it of items.value) {
            if (it.previewUrl) URL.revokeObjectURL(it.previewUrl)
        }
        items.value = []
    }
}

function getImageSrc(img) {
    // dacă e fișier uploadat
    if (img instanceof File) {
        return URL.createObjectURL(img)
    }
    if (typeof img === 'string') {
        return img
    }

    if (img && img.url) {
        return img.url
    }
    return null
}

const loadingReviews = ref(false)
async function fetchReviews(productId, url = null) {
    loadingReviews.value = true
    generalError.value = null
    formErrors.value = {}

    try {
        const res = await axiosClient.get(
            url || `/products/${productId}/reviews`,
        )

        // page 1 => replace
        if (!url) {
            reviews.value = res.data.data
        } else {
            // page 2+ => add
            reviews.value.push(...res.data.data)
        }

        reviewsMeta.value = res.data.meta || {}
        nextPageUrl.value = res.data.links?.next || null
    } catch (err) {
        handleApiError(err)
        console.error('Eroare la fetch reviews:', err)
    } finally {
        loadingReviews.value = false
    }
}
async function fetchProduct(slug) {
    generalError.value = null
    formErrors.value = {}

    try {
        const res = await axiosClient.get(`/product/${slug}`)
        product.value = res.data.data
        basePrice.value =
            product.value?.discounted_price || product.value?.price || 0

        const glitterRes = await axiosClient.get(
            `/glitter-addons?type=glitters`,
        )
        glitterAddons.value = glitterRes.data.data || []

        await fetchReviews(product.value?.id)

        if (product.value?.categories?.length) {
            const firstCat = product.value?.categories[0].id
            const similars = await axiosClient.get(
                `/products?category_id=${firstCat}`,
            )
            similarProducts.value = (similars.data.data || []).filter(
                (p) => p.id !== product.value.id,
            )
        }

        window.scrollTo({ top: 0, behavior: 'smooth' })
    } catch (err) {
        console.log('Eroare fetch produs: ', err)
        handleApiError(err)
    }
}

onMounted(() => fetchProduct(route.params.slug))

watch(
    () => route.params.slug,
    async (newSlug, oldSlug) => {
        if (newSlug !== oldSlug) {
            await fetchProduct(newSlug)
        }
    },
)
function onFilesChange(filesArray) {
    const files = (filesArray || []).filter((file) => file instanceof File)
    if (files.length) newImages.value.push(...files)
}
function onToggleFavorite(p, e) {
    e?.stopPropagation?.()
    store.toggleFavorite(p).catch((err) => {
        console.error('Eroare toggle favorite', err)
        handleApiError(err)
    })
}

function getUploadToken() {
    const key = 'upload_token'
    let t = localStorage.getItem(key)
    if (!t) {
        // fallback
        t = Date.now().toString(36) + Math.random().toString(36).slice(2)

        localStorage.setItem(key, t)
    }
    return t
}

const items = ref([])
function validateFiles(files) {
    const allowed = ['image/jpeg', 'image/png', 'image/jpg']
    const maxMB = 10
    const maxCount = 3

    const current = items.value.length
    const toAdd = []

    for (const f of files) {
        if (current + toAdd.length >= maxCount) break
        if (!allowed.includes(f.type)) continue
        if (f.size > maxMB * 1024 * 1024) continue
        toAdd.push(f)
    }
    return toAdd
}

// watch(
//     items,
//     (newItems, oldItems) => {
//         console.log(
//             'ITEMS CHANGED',
//             newItems.map((i) => ({
//                 id: i.id,
//                 status: i.status,
//                 progress: i.progress,
//             })),
//         )
//     },
//     { deep: true },
// )

function uid() {
    return Math.random().toString(36).slice(2) + Date.now().toString(36)
}
async function onFilesPicked(eOrFiles) {
    const rawFiles = eOrFiles?.target?.files
        ? Array.from(eOrFiles.target.files)
        : Array.isArray(eOrFiles)
          ? eOrFiles
          : []

    if (eOrFiles?.target) eOrFiles.target.value = ''

    const files = validateFiles(rawFiles)
    if (!files.length) return

    for (const file of files) {
        const it = reactive({
            id: uid(),
            file,
            previewUrl: URL.createObjectURL(file),
            status: 'uploading',
            progress: 0,
            url: null,
            error: null,
        })
        items.value.push(it)
        uploadOne(it)
    }
}

const isUploading = computed(() =>
    items.value.some((x) => x.status === 'uploading'),
)

async function uploadOne(it) {
    const fd = new FormData()
    fd.append('upload_token', getUploadToken())
    fd.append('photo', it.file)

    try {
        const res = await axiosClient.post('/upload/order-photo', fd, {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: (evt) => {
                if (!evt.total) return
                it.progress = Math.round((evt.loaded * 100) / evt.total)
            },
        })

        if (!res.data?.success || !res.data?.url) {
            throw new Error('Upload invalid')
        }

        it.url = res.data.url
        it.status = 'done'
        it.progress = 100
        it.error = null
    } catch (err) {
        console.error('Upload error:', err)

        it.status = 'error'
        it.progress = 0

        if (err.response) {
            it.error = err.response.data?.message || 'Eroare la upload (server)'
        } else if (err.request) {
            it.error = 'Eroare de rețea'
        } else {
            it.error = err.message || 'Eroare necunoscută'
        }
    }
}

onBeforeUnmount(() => {
    for (const it of items.value) {
        if (it.previewUrl) URL.revokeObjectURL(it.previewUrl)
    }
})

function removeItem(idx) {
    const it = items.value[idx]
    if (it?.previewUrl) URL.revokeObjectURL(it.previewUrl)
    items.value.splice(idx, 1)
}

function getUploadedUrls() {
    return items.value
        .filter((x) => x.status === 'done' && x.url)
        .map((x) => x.url)
}

const handleAddToCart = () => {
    if (!product.value) return

    if (items.value.length === 0) photoSelected.value = false

    if (photoSelected.value && isUploading.value) return

    const photoUrls = photoSelected.value ? getUploadedUrls() : []

    const glitter = selectedGlitterId.value
        ? glitterAddons.value.find((g) => g.id === selectedGlitterId.value)
        : null

    store.addToCart({
        product: product.value,
        quantity: 1,
        addons: {
            ribbonText: ribbonText.value,
            glitterId: selectedGlitterId.value,
            glitterColor: glitter ? glitter.hex_code : null,
            led: ledSelected.value,
            photoSelected: photoSelected.value,
            photoCount: items.value.length,
            photoUrls,
        },
        unitPrice: currentPrice.value,
    })

    router.push('/cart')
}
</script>

<style scoped></style>
