<template>
    <div class="mt-1 mb-10 overflow-x-hidden">
        <div class="relative right-1/2 left-1/2 -mx-[50vw] w-screen">
            <div class="mx-auto max-w-11/12 sm:max-w-xl">
                <section class="w-full">
                    <CheckoutSteps :current-step="3" />

                    <!-- Success Animation -->
                    <div class="mb-12 text-center">
                        <div
                            class="relative mb-6 inline-flex items-center justify-center md:mb-8"
                        >
                            <div
                                :style="{ animationDuration: '2s' }"
                                class="bg-rosegold-300 absolute inset-0 animate-ping rounded-full"
                            />
                            <div
                                class="bg-rosegold-300 relative flex h-20 w-20 items-center justify-center rounded-full md:h-24 md:w-24"
                            >
                                <CheckCircle2
                                    class="text-rosegold-700 h-10 w-10 md:h-12 md:w-12"
                                />
                            </div>
                        </div>

                        <h1
                            class="mb-4 font-serif text-3xl font-bold tracking-tight md:text-4xl"
                        >
                            Mulțumim pentru comandă!
                        </h1>

                        <p
                            class="mx-auto mb-2 max-w-md font-sans text-lg text-gray-800"
                        >
                            Comanda ta a fost plasată cu succes și va fi
                            procesată în curând.
                        </p>

                        <div
                            class="text-rosegold-700 flex items-center justify-center gap-2 text-lg"
                        >
                            <Heart class="h-5 w-5 fill-current" />
                            <span class="font-serif font-semibold"
                                >Îți mulțumim că ai ales florăria noastră!</span
                            >
                            <Heart class="h-5 w-5 fill-current" />
                        </div>
                    </div>

                    <div
                        class="bg-rosegold-100/60 flex flex-col items-center justify-center gap-3 rounded-xl p-4"
                    >
                        <p class="font-serif text-lg text-gray-600 md:text-xl">
                            Numărul comenzii tale:
                        </p>
                        <p
                            class="text-rosegold-700 font-serif text-2xl font-bold md:text-3xl"
                        >
                            #{{ orderNumber }}
                        </p>
                        <p class="text-md text-center font-serif text-gray-600">
                            Vei primi un e-mail de confirmare cu toate detaliile
                            comenzii.
                        </p>
                    </div>

                    <button
                        class="hover:bg-rosegold-500 group mt-6 flex w-full items-center justify-center border border-gray-300 px-4 py-2 transition-colors"
                        style="border-radius: 10px"
                        @click="redirectOrder"
                    >
                        <span
                            class="flex items-center gap-2 font-sans text-[16px] text-gray-900 group-hover:text-white lg:text-lg"
                        >
                            <Sparkles class="mr-2 h-5 w-5 lg:h-6 lg:w-6" />
                            Vezi detalii comandă</span
                        >
                    </button>

                    <div
                        class="mt-6 rounded-xl bg-[rgba(204,204,204,0.2)] p-2 md:p-4"
                    >
                        <div
                            class="flex flex-col items-center justify-center gap-4"
                        >
                            <p
                                class="font-serif text-lg font-semibold text-gray-600 md:text-xl"
                            >
                                Cum a fost experiența ta?
                            </p>
                            <p>A fost ușor să comanzi de pe site-ul nostru?</p>
                        </div>

                        <div
                            v-if="!feedbackSubmitted"
                            class="flex items-center justify-center gap-6"
                        >
                            <button
                                class="group flex flex-col items-center gap-3 rounded-2xl p-6 transition-all duration-300"
                                type="button"
                                @click="handleFeedback('like')"
                            >
                                <div
                                    class="flex h-16 w-16 items-center justify-center rounded-full bg-green-100 transition-colors group-hover:bg-green-200"
                                >
                                    <ThumbsUp
                                        class="h-8 w-8 text-green-600 transition-transform group-hover:scale-110"
                                    />
                                </div>
                                <span class="font-serif font-medium"
                                    >Da, a fost ușor!</span
                                >
                            </button>

                            <button
                                class="group flex flex-col items-center gap-3 rounded-2xl p-6 transition-all duration-300"
                                type="button"
                                @click="handleFeedback('dislike')"
                            >
                                <div
                                    class="flex h-16 w-16 items-center justify-center rounded-full bg-red-100 transition-colors group-hover:bg-red-200"
                                >
                                    <ThumbsDown
                                        class="h-8 w-8 text-red-600 transition-transform group-hover:scale-110"
                                    />
                                </div>
                                <span class="font-serif font-medium"
                                    >Am întâmpinat dificultăți</span
                                >
                            </button>
                        </div>

                        <div v-else class="py-6">
                            <div
                                v-if="feedback === 'like'"
                                class="flex flex-col items-center gap-4"
                            >
                                <div
                                    class="flex h-16 w-16 items-center justify-center rounded-full bg-green-100"
                                >
                                    <ThumbsUp class="h-8 w-8 text-green-600" />
                                </div>
                                <div class="text-center">
                                    <p
                                        class="mb-1 font-serif text-lg font-semibold"
                                    >
                                        Ne bucurăm să auzim asta!
                                    </p>
                                    <p class="font-serif">
                                        Mulțumim pentru feedback-ul tău pozitiv!
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            v-if="feedback === 'dislike'"
                            class="flex flex-col items-center gap-4"
                        >
                            <div
                                class="flex h-16 w-16 items-center justify-center rounded-full bg-amber-100"
                            >
                                <ThumbsDown class="h-8 w-8 text-amber-600" />
                            </div>
                            <div class="text-center">
                                <p
                                    class="mb-1 font-serif text-lg font-semibold"
                                >
                                    Ne pare rău să auzim asta
                                </p>
                                <p class="mb-4 font-serif">
                                    Lucrăm constant să îmbunătățim experiența.
                                    Feedback-ul tău ne ajută!
                                </p>
                                <button
                                    class="cursor-pointer rounded-lg bg-white px-2 py-0.5 transition-colors hover:outline"
                                >
                                    Spune-ne mai multe
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import {
    CheckCircle2,
    Heart,
    Sparkles,
    ThumbsDown,
    ThumbsUp,
} from 'lucide-vue-next'
import CheckoutSteps from '../components/core/checkout-page/CheckoutSteps.vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const feedback = ref(null)
const feedbackSubmitted = ref(false)

const orderId = computed(() => route.params.orderId)
const orderNumber = computed(() => route.query.orderNumber)
const handleFeedback = (type) => {
    feedback.value = type
    feedbackSubmitted.value = true
    //to backend
}
const redirectOrder = () => {
    router.push({ name: 'app.orders', params: { orderId: orderId.value } })
}
</script>
