<script setup>
import '../css/app.css'
import { useFieldErrors } from '../utils/useFieldErrors.js'
import { reactive, ref } from 'vue'
import MyInput from '../components/core/MyInput.vue'
import ErrorAlert from '../components/core/ErrorAlert.vue'
import { useRouter } from 'vue-router'
import { useToast } from '../utils/myToast.js'
import { useAppStore } from '../store/index.js'

const { showToast } = useToast()

const store = useAppStore()

const userData = reactive({
    last_name: '',
    first_name: '',
    email: '',
    phone_number: '',
    password: '',
    confirm_password: '',
    terms_cond: false,
    pol_conf: false,
})
const loading = ref(false)

const router = useRouter()

const { formErrors, generalError, handleApiError } = useFieldErrors()

async function handleRegister() {
    loading.value = true
    formErrors.value = {}
    generalError.value = null

    if (!userData.terms_cond || !userData.pol_conf) {
        generalError.value = 'Trebuie să acceptați termenii și condițiile'
        loading.value = false
        return
    }

    if (userData.password !== userData.confirm_password) {
        generalError.value = 'Parolele nu coincid'
        loading.value = false
        return
    }

    try {
        await store.register(userData)
        await router.push('/login')
        showToast('Contul a fost creat cu succes!', 'success')
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
        <form method="POST" @submit.prevent="handleRegister">
            <div class="space-y-4">
                <div class="border-b border-gray-900/10 pb-4">
                    <p
                        class="font-serif text-2xl font-semibold text-gray-900 sm:text-3xl"
                    >
                        Creează-ți un cont!
                    </p>
                    <p class="text-xl">
                        Ai cont deja?
                        <RouterLink class="link-terms" to="/login"
                            >Autentifică-te!</RouterLink
                        >
                    </p>
                    <div
                        class="mt-10 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6"
                    >
                        <div class="sm:col-span-3">
                            <label
                                class="block text-lg font-medium text-gray-900"
                                for="last_name"
                                >Nume <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div>
                                    <input
                                        id="last_name"
                                        v-model="userData.last_name"
                                        class="focus:ring-rosegold-500 hover:ring-rosegold-700 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                        name="last_name"
                                        placeholder="Popescu"
                                        style="font-size: 18px"
                                        type="text"
                                        @input="formErrors.last_name = null"
                                    />
                                </div>
                                <p
                                    v-if="formErrors.last_name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ formErrors.last_name }}
                                </p>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label
                                class="block text-lg font-medium text-gray-900"
                                for="first_name"
                                >Prenume
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div>
                                    <input
                                        id="first_name"
                                        v-model="userData.first_name"
                                        class="focus:ring-rosegold-500 hover:ring-rosegold-700 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                        name="first_name"
                                        placeholder="Vasile"
                                        style="font-size: 18px"
                                        type="text"
                                        @input="formErrors.first_name = null"
                                    />
                                </div>
                                <p
                                    v-if="formErrors.first_name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ formErrors.first_name }}
                                </p>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label
                                class="block text-lg font-medium text-gray-900"
                                for="email"
                                >E-mail
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div>
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

                        <div class="sm:col-span-3">
                            <label
                                class="block text-lg font-medium text-gray-900"
                                for="phone_number"
                                >Telefon
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div>
                                    <input
                                        id="phone_number"
                                        v-model="userData.phone_number"
                                        class="focus:ring-rosegold-500 hover:ring-rosegold-700 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                        name="phone_number"
                                        placeholder="0754322400"
                                        style="font-size: 18px"
                                        type="text"
                                        @input="formErrors.phone_number = null"
                                    />
                                </div>
                                <p
                                    v-if="formErrors.phone_number"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ formErrors.phone_number }}
                                </p>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label
                                class="block text-lg font-medium text-gray-900"
                                for="password"
                                >Parolă
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div>
                                    <input
                                        id="password"
                                        v-model="userData.password"
                                        class="focus:ring-rosegold-500 hover:ring-rosegold-700 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
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
                                for="confirm_password"
                                >Confirmă parola
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div>
                                    <input
                                        id="confirm_password"
                                        v-model="userData.confirm_password"
                                        class="focus:ring-rosegold-500 hover:ring-rosegold-700 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                        name="confirm_password"
                                        placeholder="********"
                                        style="font-size: 18px"
                                        type="password"
                                        @input="
                                            formErrors.confirm_password = null
                                        "
                                    />
                                </div>
                                <p
                                    v-if="formErrors.confirm_password"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ formErrors.confirm_password }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-900/10 pb-2">
                    <div class="space-y-10">
                        <fieldset>
                            <div class="space-y-1">
                                <div class="flex gap-3">
                                    <div class="flex h-6 shrink-0 items-center">
                                        <div
                                            class="group grid size-4 grid-cols-1"
                                        >
                                            <MyInput
                                                v-model="userData.terms_cond"
                                                class="border-none shadow-none"
                                                type="checkbox"
                                                @input="
                                                    formErrors.terms_cond = null
                                                "
                                            />
                                            <p
                                                v-if="formErrors.terms_cond"
                                                class="mt-1 text-sm text-red-600"
                                            >
                                                {{ formErrors.terms_cond }}
                                            </p>
                                            <!--  <input-->
                                            <!--  id="terms_conds"-->
                                            <!--  aria-describedby="terms-and-conditions"-->
                                            <!--  class="h-4 w-4 accent-[#B87E7A] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#B87E7A]"-->
                                            <!--  name="terms_conds"-->
                                            <!--  type="checkbox"-->
                                            <!--  />-->
                                        </div>
                                    </div>
                                    <div class="translate-y-1.5 text-lg">
                                        <p
                                            id="terms-and-conditions"
                                            class="text-gray-900"
                                        >
                                            Am citit și accept
                                            <RouterLink
                                                class="link-terms"
                                                to="/terms-and-conditions"
                                                >Termenii și
                                                condițiile</RouterLink
                                            >.
                                            <span class="text-red-600">*</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="flex h-6 shrink-0 items-center">
                                        <div
                                            class="group grid size-4 grid-cols-1"
                                        >
                                            <MyInput
                                                v-model="userData.pol_conf"
                                                class="border-none shadow-none"
                                                type="checkbox"
                                                @input="
                                                    formErrors.pol_conf = null
                                                "
                                            />
                                            <p
                                                v-if="formErrors.pol_conf"
                                                class="mt-1 text-sm text-red-600"
                                            >
                                                {{ formErrors.pol_conf }}
                                            </p>
                                            <!-- <input-->
                                            <!-- id="pol_conf"-->
                                            <!-- aria-describedby="policy-of-confidentiality"-->
                                            <!-- class="h-4 w-4 accent-[#B87E7A] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#B87E7A]"-->
                                            <!-- name="pol_conf"-->
                                            <!-- type="checkbox"-->
                                            <!-- />-->
                                        </div>
                                    </div>
                                    <div class="translate-y-1.5 text-lg">
                                        <p
                                            id="policy-of-confidentiality"
                                            class="text-gray-900"
                                        >
                                            Am citit și sunt de acord cu
                                            <RouterLink
                                                class="link-terms"
                                                to="/privacy-policy"
                                                >Politica de
                                                Confidențialitate</RouterLink
                                            >.
                                            <span class="text-red-600">*</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <ErrorAlert :message="generalError" />

            <div class="mt-4 flex items-center justify-center gap-x-6">
                <button
                    :disabled="loading"
                    class="bg-rosegold-700 hover:bg-rosegold-500 focus-visible:outline-rosegold-700 rounded-md px-7 py-2 font-semibold text-white shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2"
                    style="border-radius: 10px"
                    type="submit"
                >
                    <span class="text-lg">{{
                        loading ? 'Se creează...' : 'Creează'
                    }}</span>
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
