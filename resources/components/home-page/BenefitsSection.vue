<template>
    <div
        class="mt-20 flex flex-wrap items-center justify-between gap-6 rounded-xl border px-4 py-6"
    >
        <div
            v-for="(benefit, index) in benefits"
            :key="index"
            class="flex aspect-square w-30 flex-col items-center rounded-lg text-center shadow-md"
            @click="onClickShowBenefitModal(benefit)"
        >
            <div class="mb-2 text-2xl">
                <component
                    :is="benefit.icon"
                    v-if="typeof benefit.icon !== 'string'"
                    class="h-9 w-9"
                />
                <v-icon v-else :name="benefit.icon" class="h-9 w-9" />
            </div>
            <p class="font-serif text-lg">{{ benefit.title }}</p>
            <p v-if="benefit.subtitle" class="text-lg font-thin text-black">
                {{ benefit.subtitle }}
            </p>
        </div>
        <BenefitsModal v-model="showBenefitModal" :benefit="selectedBenefit" />
    </div>
</template>

<script setup>
import BenefitsModal from './BenefitsModal.vue'
import { ref } from 'vue'

const benefits = [
    {
        icon: 'co-openstreetmap',
        title: 'Romania',
        subtitle: '24h',
        description: 'Livrare oriunde in tara in 24 de ore',
    },
    {
        icon: 'bi-hourglass-split',
        title: 'Etern',
        subtitle: '∞︎',
        description: 'Buchetele noastre nu ofilesc niciodata!',
    },
    {
        icon: 'md-supportagent',
        title: '24/7',
        subtitle: 'Suport 24/7',
        description: 'Va vom oferi ajutor in orice moment!',
    },
    {
        icon: 'bi-box-seam',
        title: 'Impachetat cu grija',
        subtitle: '',
        description:
            'Ambalam fiecare buchet cu grija astfel incat sa ajunga la dumneavoastra intact!',
    },
]

const showBenefitModal = ref(false)
const selectedBenefit = ref(null)
function onClickShowBenefitModal(benefit = null) {
    selectedBenefit.value = benefit
    showBenefitModal.value = true
}
</script>
