<script setup>
import { useAppStore } from '../store/index.js'
import { ref } from 'vue'
import { router } from '../router/index.js'
import BenefitsSection from '../components/home-page/BenefitsSection.vue'

const store = useAppStore()
const loading = ref(false)

function logout() {
    loading.value = true
    store
        .logout()
        .then(() => {
            loading.value = false
            router.push({ name: 'login' })
        })
        .catch(({ response }) => {
            loading.value = false
            console.log(response)
        })
}
</script>

<template>
    <div class="mx-auto mt-20 max-w-10/12 px-2 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-center">
            <BenefitsSection />
            <button :disabled="loading" class="bg-rosegold-700" @click="logout">
                {{ loading ? 'Loading...' : 'Logout' }}
            </button>
        </div>
    </div>
</template>

<style scoped></style>
