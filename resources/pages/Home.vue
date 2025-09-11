<script setup>
import { useAppStore } from '../store/index.js'
import { ref } from 'vue'
import { router } from '../router/index.js'

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
    <div class="flex items-center justify-center">
        <button :disabled="loading" class="bg-rosegold-700" @click="logout">
            {{ loading ? 'Loading...' : 'Logout' }}
        </button>
    </div>
</template>

<style scoped></style>
