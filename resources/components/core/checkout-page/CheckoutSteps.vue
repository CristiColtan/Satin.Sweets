<script setup>
import { Check } from 'lucide-vue-next'
import { useRouter } from 'vue-router'

const props = defineProps({
    currentStep: Number,
})

const router = useRouter()

const routesByStep = {
    1: { name: 'app.cart' },
    2: { name: 'app.checkout' },
}

function goToStep(step) {
    if (step < props.currentStep) {
        router.push(routesByStep[step])
    }
}
</script>

<template>
    <div
        class="mt-2 mb-8 flex items-center justify-center gap-3 text-sm md:mt-6 md:gap-4 md:text-base lg:text-lg"
    >
        <!-- PAS 1 -->
        <div
            :class="[
                props.currentStep >= 1 ? 'text-rosegold-700' : 'text-gray-500',
                props.currentStep > 1 ? 'cursor-pointer' : 'cursor-default',
            ]"
            class="flex items-center gap-2"
            @click="goToStep(1)"
        >
            <div
                :class="
                    props.currentStep > 1
                        ? 'bg-rosegold-500 text-white'
                        : props.currentStep === 1
                          ? 'bg-rosegold-500 text-white'
                          : 'border border-gray-300 bg-white'
                "
                class="relative flex h-8 w-8 items-center justify-center rounded-full font-sans font-semibold"
            >
                <!-- CHECK pentru pas completat -->
                <Check
                    v-if="props.currentStep > 1"
                    class="h-5 w-5 text-white"
                />

                <!-- Număr pentru pas activ / viitor -->
                <span v-else>1</span>

                <!-- OUTLINE pentru pas curent -->
                <span
                    v-if="props.currentStep === 1"
                    class="outline-rosegold-300 absolute -inset-1 rounded-full outline outline-2"
                ></span>
            </div>

            <span class="font-sans font-semibold">Coș</span>
        </div>

        <!-- LINIE 1–2 -->
        <div
            :class="props.currentStep > 1 ? 'bg-rosegold-500' : 'bg-gray-300'"
            class="h-px w-10 md:w-16"
        ></div>

        <!-- PAS 2 -->
        <div
            :class="[
                props.currentStep >= 2 ? 'text-rosegold-700' : 'text-gray-500',
                props.currentStep > 2 ? 'cursor-pointer' : 'cursor-default',
            ]"
            class="flex items-center gap-2"
            @click="goToStep(2)"
        >
            <div
                :class="
                    props.currentStep > 2
                        ? 'bg-rosegold-500 text-white'
                        : props.currentStep === 2
                          ? 'bg-rosegold-500 text-white'
                          : 'border border-gray-300 bg-white'
                "
                class="relative flex h-8 w-8 items-center justify-center rounded-full font-sans font-semibold"
            >
                <!-- CHECK -->
                <Check
                    v-if="props.currentStep > 2"
                    class="h-5 w-5 text-white"
                />

                <span v-else>2</span>

                <!-- OUTLINE PAS CURENT -->
                <span
                    v-if="props.currentStep === 2"
                    class="outline-rosegold-300 absolute -inset-1 rounded-full outline outline-2"
                ></span>
            </div>

            <span class="font-sans font-semibold">Plată</span>
        </div>

        <!-- LINIE 2–3 -->
        <div
            :class="props.currentStep > 2 ? 'bg-rosegold-500' : 'bg-gray-300'"
            class="h-px w-10 md:w-16"
        ></div>

        <!-- PAS 3 -->
        <div
            :class="
                props.currentStep >= 3 ? 'text-rosegold-700' : 'text-gray-500'
            "
            class="flex items-center gap-2"
        >
            <div
                :class="
                    props.currentStep === 3
                        ? 'bg-rosegold-500 text-white'
                        : 'border border-gray-300 bg-white'
                "
                class="relative flex h-8 w-8 items-center justify-center rounded-full font-sans font-semibold"
            >
                <span>3</span>

                <!-- OUTLINE PAS CURENT -->
                <span
                    v-if="props.currentStep === 3"
                    class="outline-rosegold-300 absolute -inset-1 rounded-full outline outline-2"
                ></span>
            </div>

            <span class="font-sans font-semibold">Finalizare</span>
        </div>
    </div>
</template>
