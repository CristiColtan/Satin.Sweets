<template>
    <div class="grid grid-cols-1 gap-0 sm:grid-cols-2 sm:gap-8">
        <!--left-->
        <div class="flex items-center justify-center gap-6 py-5">
            <div class="gap-3">
                <p class="font-serif text-2xl">
                    Abonează-te și află ultimele noutăți.
                </p>
                <MyInput v-model="email" class="bg-transparent" label="Email" />
                <button
                    class="bg-rosegold-500 hover:bg-rosegold-700 focus:ring-rosegold-500 mt-2 w-full justify-center rounded-md border border-gray-300 px-4 py-1.5 text-lg font-medium text-white shadow-sm focus:ring-2 focus:ring-offset-2 focus:outline-none sm:w-auto"
                    type="submit"
                >
                    <span class="text-lg">Trimite</span>
                </button>
            </div>
        </div>
        <!--right-->
        <div class="mt-2 flex w-full items-center justify-center px-3">
            <div class="w-full max-w-md space-y-2 text-left">
                <div
                    v-for="(benefit, i) in benefits_subscribe"
                    :key="i"
                    class="flex items-start gap-3"
                >
                    <component
                        :is="benefit.icon"
                        class="h-9 w-9 flex-shrink-0 sm:h-8 sm:w-8"
                    />
                    <p class="text-lg font-thin text-black">
                        {{ benefit.description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import MyInput from '../core/MyInput.vue'
import { ref } from 'vue'
import { benefits_subscribe } from '../../utils/imports.js'

const email = ref('')
</script>
