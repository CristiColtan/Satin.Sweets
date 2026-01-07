<script setup>
import { useFieldErrors } from '../utils/useFieldErrors.js'
import { reactive, ref } from 'vue'
import axiosClient from '../js/axios.js'
import ErrorAlert from '../components/core/ErrorAlert.vue'

const { formErrors, generalError, handleApiError } = useFieldErrors()

const userData = reactive({ email: '' })

const loading = ref(false)
const successMessage = ref('')

async function handleForgotPassword() {
    loading.value = true
    formErrors.value = {}
    generalError.value = null

    if (!userData.email) {
        generalError.value = 'Trebuie să introduceți email-ul'
        loading.value = false
        return
    }

    try {
        await axiosClient.post('/forgot-password', userData)
        successMessage.value =
            'Dacă există un cont cu acest email, vei primi un link de resetare a parolei.'
    } catch (err) {
        handleApiError(err)
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <div
        class="flex flex-col items-center justify-center bg-[#f3f3f3] p-6 sm:p-14"
    >
        <form
            class="w-full max-w-lg"
            method="POST"
            @submit.prevent="handleForgotPassword"
        >
            <div class="space-y-4">
                <div class="border-b border-gray-900/10 pb-4">
                    <p
                        class="font-serif text-2xl font-semibold text-gray-900 sm:text-3xl"
                    >
                        Recuperează parola!
                    </p>
                    <p></p>
                    <div
                        class="mt-10 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6"
                    >
                        <div class="sm:col-span-18">
                            <label
                                class="block text-lg font-medium text-gray-900"
                                for="email"
                            >
                                E-mail <span class="text-red-600">*</span>
                            </label>
                            <div class="mt-2">
                                <div class="flex items-center">
                                    <input
                                        id="email"
                                        v-model="userData.email"
                                        class="focus:ring-rosegold-500 hover:ring-rosegold-700 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                        name="email"
                                        placeholder="popescu.vasile@yahoo.com"
                                        style="font-size: 18px"
                                        type="text"
                                        @input="formErrors.email = null"
                                    />
                                </div>
                                <p
                                    v-if="formErrors.email"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ formErrors.email }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <ErrorAlert :message="generalError" />

                <Transition name="fade-slide">
                    <div
                        v-if="successMessage"
                        class="flex items-center justify-center rounded-lg bg-green-100 px-3 py-2 text-green-800 shadow-md"
                    >
                        <span class="font-serif text-lg">{{
                            successMessage
                        }}</span>
                    </div>
                </Transition>

                <div
                    class="flex-cols mt-2 flex items-center justify-center gap-x-6"
                >
                    <div class="flex items-center justify-center gap-6">
                        <p
                            class="flex items-center justify-center font-serif text-xl"
                        >
                            <RouterLink class="link-terms" to="/register"
                                >Creează cont</RouterLink
                            >
                        </p>
                        <p
                            class="flex items-center justify-center font-serif text-xl"
                        >
                            <RouterLink class="link-terms" to="/login"
                                >Login</RouterLink
                            >
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-center">
                    <button
                        :disabled="loading"
                        class="bg-rosegold-700 hover:bg-rosegold-500 focus-visible:outline-rosegold-700 rounded-md px-10 py-2 text-sm font-semibold text-white shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2"
                        style="border-radius: 10px"
                        type="submit"
                    >
                        <span class="text-lg">{{
                            loading ? 'Se trimite...' : 'Trimite'
                        }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
