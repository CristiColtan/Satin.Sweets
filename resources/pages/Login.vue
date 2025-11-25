<script setup>
import { reactive, ref } from 'vue'
import { useAppStore } from '../store/index.js'
import { useFieldErrors } from '../utils/useFieldErrors.js'
import { useRoute, useRouter } from 'vue-router'
import ErrorAlert from '../components/core/ErrorAlert.vue'

const emit = defineEmits(['submit'])

const store = useAppStore()
const route = useRoute()
const router = useRouter()
const userData = reactive({ email: '', password: '' })

const loading = ref(false)

/*watch(
    userData,
    () => {
        console.log(
            'USER:',
            userData,
            // userData.value.email,
            // userData.value.password,
        )
    },
    // { deep: true },
)*/

const { formErrors, generalError, handleApiError } = useFieldErrors()
async function login() {
    loading.value = true
    formErrors.value = {}
    generalError.value = null

    try {
        await store.login(userData)
        const fallbackPath = store.user.data?.is_admin ? '/admin' : '/'
        const back =
            typeof route.query.redirect === 'string'
                ? route.query.redirect
                : fallbackPath

        await router.replace(back)
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
        <form class="w-full max-w-xl" @submit.prevent="login">
            <div class="space-y-4">
                <div class="border-b border-gray-900/10 pb-4">
                    <p
                        class="font-serif text-2xl font-semibold text-gray-900 sm:text-3xl"
                    >
                        Autentifica-te!
                    </p>
                    <p class="text-xl">
                        Nu ai un cont?
                        <RouterLink class="link-terms" to="/register"
                            >Creeaza unul acum!</RouterLink
                        >
                    </p>
                    <div
                        class="mt-10 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6"
                    >
                        <div class="sm:col-span-3">
                            <label
                                class="block text-lg font-medium text-gray-900"
                                for="email"
                            >
                                E-mail <span class="text-red-600">*</span>
                            </label>
                            <div class="mt-2">
                                <div
                                    class="focus-within:outline-rosegold-500 flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2"
                                >
                                    <input
                                        id="email"
                                        v-model="userData.email"
                                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
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

                        <div class="sm:col-span-3">
                            <label
                                class="block text-lg font-medium text-gray-900"
                                for="password"
                                >Parola
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div
                                    class="focus-within:outline-rosegold-500 flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2"
                                >
                                    <input
                                        id="password"
                                        v-model="userData.password"
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
                    </div>
                    <ErrorAlert :message="generalError" />
                </div>
            </div>

            <div
                class="mt-2 grid grid-rows-2 items-center justify-center gap-x-6"
            >
                <p class="flex items-center justify-center font-serif text-lg">
                    <RouterLink class="link-terms" to="/reset-password"
                        >Ai uitat parola?</RouterLink
                    >
                </p>
                <button
                    :disabled="loading"
                    class="bg-rosegold-700 hover:bg-rosegold-500 focus-visible:outline-rosegold-700 rounded-md px-10 py-2 font-semibold text-white shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2"
                    style="border-radius: 10px"
                    type="submit"
                >
                    <span class="text-lg">{{
                        loading ? 'Loading...' : 'Login'
                    }}</span>
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
