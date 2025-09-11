<script setup>
import { router } from '../router/index.js'
import { reactive, ref } from 'vue'
import { useAppStore } from '../store/index.js'

const emit = defineEmits(['submit'])

const store = useAppStore()
const userData = reactive({ email: '', password: '' })

const loading = ref(false)
const errorMsg = ref('')

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

function login() {
    loading.value = true
    store
        .login(userData)
        .then(() => {
            loading.value = false
            router.push({ name: 'app.home' })
        })
        .catch((err) => {
            loading.value = false
            errorMsg.value =
                err?.response?.data?.message ||
                err?.message ||
                'Eroare la autentificare'
        })
}
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center justify-center bg-[#f3f3f3] p-6 sm:p-14"
    >
        <form class="w-full max-w-md" @submit.prevent="login">
            <div class="space-y-4">
                <div class="border-b border-gray-900/10 pb-4">
                    <h2 class="text-base/7 font-semibold text-gray-900">
                        Autentifica-te!
                    </h2>
                    <p class="">
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
                                class="block text-sm/6 font-medium text-gray-900"
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
                                        type="text"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
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
                                        type="password"
                                    />
                                </div>
                            </div>
                        </div>
                        <p v-if="errorMsg" class="text-red-600">
                            {{ errorMsg }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="mt-2 grid grid-rows-2 items-center justify-center gap-x-6"
            >
                <p class="flex items-center justify-center">
                    <RouterLink class="link-terms" to="/reset-password"
                        >Ai uitat parola?</RouterLink
                    >
                </p>
                <button
                    :disabled="loading"
                    class="bg-rosegold-700 hover:bg-rosegold-500 focus-visible:outline-rosegold-700 rounded-md px-10 py-2 text-sm font-semibold text-white shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2"
                    type="submit"
                >
                    {{ loading ? 'Loading...' : 'Login' }}
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
