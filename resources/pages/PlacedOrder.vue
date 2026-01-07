<template>
    <div class="mt-20 mb-20 overflow-x-hidden">
        <div class="relative right-1/2 left-1/2 -mx-[50vw] w-screen">
            <div class="mx-auto max-w-11/12 sm:max-w-10/12">
                <section class="w-full">
                    <CheckoutSteps :current-step="3" />
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import CheckoutSteps from '../components/core/checkout-page/CheckoutSteps.vue'
</script>
