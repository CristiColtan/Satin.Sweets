<template>
    <div class="mt-20 w-full bg-[rgba(204,204,204,0.2)] py-8">
        <div class="mx-auto w-10/12">
            <div class="hidden gap-6 sm:grid sm:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="(benefit, index) in benefits"
                    :key="index"
                    class="flex flex-col items-center text-center"
                    @click="onClickShowBenefitModal(benefit)"
                >
                    <div
                        class="bg-rosegold-100 group-hover:bg-rosegold-300 mb-1 rounded-full p-3 transition-colors"
                    >
                        <component
                            :is="benefit.icon"
                            class="text-rosegold-700 h-7 w-7"
                        />
                    </div>
                    <h3
                        class="text-foreground font-serif text-xl font-semibold"
                    >
                        {{ benefit.title }}
                    </h3>
                    <p class="text-[14px] leading-relaxed font-thin text-black">
                        {{ benefit.description }}
                    </p>
                </div>
            </div>

            <div class="block sm:hidden">
                <Swiper
                    :centered-slides="true"
                    :loop="true"
                    :modules="[Pagination]"
                    :pagination="{ clickable: true }"
                    :slides-per-view="2"
                    :space-between="16"
                >
                    <SwiperSlide
                        v-for="(benefit, index) in benefits"
                        :key="index"
                    >
                        <div
                            class="flex flex-col items-center text-center"
                            style="min-height: 250px"
                            @click="onClickShowBenefitModal(benefit)"
                        >
                            <div
                                class="bg-rosegold-100 group-hover:bg-rosegold-300 mb-1 rounded-full p-3 transition-colors"
                            >
                                <component
                                    :is="benefit.icon"
                                    class="text-rosegold-700 h-7 w-7"
                                />
                            </div>
                            <h3
                                class="text-foreground mb-2 font-serif text-xl font-semibold"
                            >
                                {{ benefit.title }}
                            </h3>
                            <p
                                class="text-[14px] leading-relaxed font-thin text-black"
                            >
                                {{ benefit.description }}
                            </p>
                        </div>
                    </SwiperSlide>
                </Swiper>
            </div>
        </div>

        <BenefitsModal v-model="showBenefitModal" :benefit="selectedBenefit" />
    </div>
</template>

<script setup>
import { ref } from 'vue'
import {
    Heart,
    Hourglass,
    MessageCircleQuestionMark,
    Truck,
} from 'lucide-vue-next'
import BenefitsModal from './BenefitsModal.vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Pagination } from 'swiper/modules'

import 'swiper/css'
import 'swiper/css/pagination'

const showBenefitModal = ref(false)
const selectedBenefit = ref(null)
function onClickShowBenefitModal(benefit = null) {
    selectedBenefit.value = benefit
    showBenefitModal.value = true
}

const benefits = [
    {
        icon: Truck,
        title: 'Livrare Rapidă',
        description: 'Livrăm în 24 de ore oriunde în tara',
        details: 'Livrare gratuită pentru comenzi peste 265 RON.',
    },
    {
        icon: Hourglass,
        title: 'Eleganta eterna',
        description: 'Buchetele noastre nu ofilesc niciodata!',
        details:
            'Spune adio florilor trecătoare – Fiecare buchet este creat pentru a rezista în timp, păstrându-și forma și farmecul fără grija ofilirii.',
    },
    {
        icon: Heart,
        title: 'Aranjamente Personalizate',
        description: 'Creăm buchete unice pentru tine',
        details:
            'Echipa noastră creează aranjamente personalizate pentru orice ocazie specială.',
    },
    {
        icon: MessageCircleQuestionMark,
        title: 'Disponibili 24/7 pentru tine',
        description: 'Comandă oricând, suport rapid',
        details:
            'Comandă în orice moment și primește ajutor rapid – suntem disponibili non-stop, pentru ca tu să te bucuri de cadourile tale fără griji.',
    },
]
</script>

<style scoped>
:deep(.swiper-pagination-bullet-active) {
    background: rosybrown; /* activ */
    opacity: 1;
}

.benefit-card {
    box-shadow: 0 0 0 rgba(0, 0, 0, 0); /* fără umbră inițial */
    transform: scale(1);
    transition:
        box-shadow 0.3s ease-in-out,
        transform 0.3s ease-in-out;
}

.benefit-card:hover {
    box-shadow:
        0 20px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
    transform: scale(1.05);
}
</style>
