<template>
    <div
        class="flex flex-col items-center justify-center bg-[#f3f3f3] p-6 sm:p-14"
    >
        <form method="POST" @submit.prevent="handleResetPassword">
            <div class="space-y-4">
                <div class="border-b border-gray-900/10 pb-4">
                    <p
                        class="font-serif text-2xl font-semibold text-gray-900 sm:text-3xl"
                    >
                        Resetează parola!
                    </p>

                    <div
                        class="mt-10 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6"
                    >
                        <div class="sm:col-span-3">
                            <label
                                class="block text-lg font-medium text-gray-900"
                                for="last_name"
                                >Parolă nouă
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div
                                    class="focus-within:outline-rosegold-500 flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2"
                                >
                                    <input
                                        id="password"
                                        v-model="form.password"
                                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                        name="password"
                                        placeholder="********"
                                        style="font-size: 18px"
                                        type="password"
                                        @input="formErrors.password = null"
                                    />
                                </div>
                                <p
                                    v-if="formErrors.password"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ formErrors.password }}
                                </p>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label
                                class="block text-lg font-medium text-gray-900"
                                for="last_name"
                                >Confirmă parola nouă
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div
                                    class="focus-within:outline-rosegold-500 flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2"
                                >
                                    <input
                                        id="password_confirmation"
                                        v-model="form.password_confirmation"
                                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                        name="password_confirmation"
                                        placeholder="********"
                                        style="font-size: 18px"
                                        type="password"
                                        @input="
                                            formErrors.password_confirmation =
                                                null
                                        "
                                    />
                                </div>
                                <p
                                    v-if="formErrors.password_confirmation"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ formErrors.password_confirmation }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ErrorAlert :message="generalError" />

            <div class="mt-2 flex items-center justify-center gap-6">
                <p class="flex items-center justify-center font-serif text-xl">
                    <RouterLink class="link-terms" to="/register"
                        >Creează cont</RouterLink
                    >
                </p>
                <p class="flex items-center justify-center font-serif text-xl">
                    <RouterLink class="link-terms" to="/login"
                        >Login</RouterLink
                    >
                </p>
            </div>

            <div class="mt-2 flex items-center justify-center gap-x-6">
                <button
                    :disabled="loading"
                    class="bg-rosegold-700 hover:bg-rosegold-500 focus-visible:outline-rosegold-700 rounded-md px-7 py-2 font-semibold text-white shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2"
                    style="border-radius: 10px"
                    type="submit"
                >
                    <span class="text-lg">{{
                        loading ? 'Se resetează...' : 'Resetează'
                    }}</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue'
import { useFieldErrors } from '../utils/useFieldErrors.js'
import axiosClient from '../js/axios.js'
import { useRoute, useRouter } from 'vue-router'
import { useToast } from '../utils/myToast.js'
import ErrorAlert from '../components/core/ErrorAlert.vue'

const { showToast } = useToast()

const route = useRoute()
const router = useRouter()

const loading = ref(false)
const { formErrors, generalError, handleApiError } = useFieldErrors()

const form = reactive({
    email: route.query.email,
    token: route.query.token,
    password: '',
    password_confirmation: '',
})

onMounted(() => {
    form.token = route.query.token || ''
    form.email = route.query.email || ''
})
async function handleResetPassword() {
    loading.value = true
    formErrors.value = {}
    generalError.value = null

    try {
        await axiosClient.post('/reset-password', form)
        showToast('Parola a fost resetată cu succes!', 'success')
        setTimeout(() => router.push({ name: 'login' }), 1200)
    } catch (err) {
        handleApiError(err)
    } finally {
        loading.value = false
    }
}
</script>
