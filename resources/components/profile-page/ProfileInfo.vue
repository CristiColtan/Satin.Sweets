<template>
    <div>
        <!--header-->
        <div class="mb-3 flex items-center justify-between">
            <p
                class="font-serif text-2xl font-medium text-gray-900 sm:text-3xl"
            >
                Informații cont
            </p>

            <template v-if="!isEditing">
                <button
                    class="hover:bg-rosegold-300 -translate-y-1 rounded-lg border border-gray-300 bg-gray-50 px-4 py-1"
                    type="button"
                    @click="isEditing = true"
                >
                    <span class="font-sans text-[15px] sm:text-lg"
                        >Editează</span
                    >
                </button>
            </template>

            <template v-else>
                <div class="flex -translate-y-1 gap-2">
                    <button
                        class="hover:bg-rosegold-700 bg-rosegold-500 rounded-lg border border-gray-300 px-2 py-1 text-white sm:px-4"
                        type="button"
                        @click="saveProfile"
                    >
                        <span
                            class="font-sans text-[15px] font-medium sm:text-lg"
                            >Salvează</span
                        >
                    </button>
                    <button
                        class="rounded-lg border border-gray-300 bg-gray-50 px-2 py-1 hover:bg-gray-100 sm:px-4"
                        type="button"
                        @click="cancelEditing"
                    >
                        <span class="font-sans text-[15px] sm:text-lg"
                            >Anulează</span
                        >
                    </button>
                </div>
            </template>
        </div>

        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 md:gap-4">
                <div>
                    <p class="font-serif text-lg">Prenume</p>
                    <div class="mt-1 flex items-center gap-2">
                        <UserRound class="h-6 w-6" />
                        <template v-if="isEditing">
                            <input
                                id="first_name"
                                v-model="formData.first_name"
                                class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                name="first_name"
                                style="font-size: 15px"
                                type="text"
                                @input="formErrors.first_name = null"
                            />
                        </template>
                        <template v-else>
                            <span class="font-serif text-lg text-gray-900">{{
                                profileData.first_name
                            }}</span>
                        </template>
                    </div>
                    <p
                        v-if="formErrors.first_name"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ formErrors.first_name }}
                    </p>
                </div>

                <div>
                    <p class="font-serif text-lg">Nume</p>
                    <div class="mt-1 flex items-center gap-2">
                        <UserRound class="h-6 w-6" />
                        <template v-if="isEditing">
                            <input
                                id="last_name"
                                v-model="formData.last_name"
                                class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                name="last_name"
                                style="font-size: 15px"
                                type="text"
                                @input="formErrors.last_name = null"
                            />
                        </template>
                        <template v-else>
                            <span class="font-serif text-lg text-gray-900">{{
                                profileData.last_name
                            }}</span>
                        </template>
                    </div>
                    <p
                        v-if="formErrors.last_name"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ formErrors.last_name }}
                    </p>
                </div>

                <div class="col-span-1 sm:col-span-2">
                    <p class="font-serif text-lg">E-mail</p>
                    <div class="mt-1 flex items-center gap-2">
                        <Mail class="h-6 w-6" />
                        <template v-if="isEditing">
                            <input
                                id="email"
                                v-model="formData.email"
                                class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                name="email"
                                style="font-size: 15px"
                                type="text"
                                @input="formErrors.email = null"
                            />
                        </template>
                        <template v-else>
                            <span class="font-serif text-lg text-gray-900">{{
                                profileData.email
                            }}</span>
                        </template>
                    </div>
                    <p
                        v-if="formErrors.email"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ formErrors.email }}
                    </p>
                </div>

                <div class="col-span-1 sm:col-span-2">
                    <p class="font-serif text-lg">Telefon</p>
                    <div class="mt-1 flex items-center gap-2">
                        <Phone class="h-6 w-6" />
                        <template v-if="isEditing">
                            <input
                                id="phone_number"
                                v-model="formData.phone_number"
                                class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                name="phone_number"
                                style="font-size: 15px"
                                type="text"
                                @input="formErrors.phone_number = null"
                            />
                        </template>
                        <template v-else>
                            <span class="font-serif text-lg text-gray-900">{{
                                profileData.phone_number
                            }}</span>
                        </template>
                    </div>
                    <p
                        v-if="formErrors.phone_number"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ formErrors.phone_number }}
                    </p>
                </div>
            </div>
        </div>
        <ErrorAlert :message="generalError" />
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue'
import { Mail, Phone, UserRound } from 'lucide-vue-next'
import { useAppStore } from '../../store/index.js'
import { useFieldErrors } from '../../utils/useFieldErrors.js'
import { useToast } from '../../utils/myToast.js'
import ErrorAlert from '../core/ErrorAlert.vue'

const isEditing = ref(false)
const store = useAppStore()
const { showToast } = useToast()

const defaultFormData = {
    first_name: '',
    last_name: '',
    email: '',
    phone_number: '',
}

const profileData = computed(() => {
    const data = store.user.data || {}
    return {
        first_name: data.first_name || '',
        last_name: data.last_name || '',
        email: data.email || '',
        phone_number: data.phone_number || '',
    }
})

onMounted(() => {
    Object.assign(formData, profileData.value)
})

const formData = reactive({ ...defaultFormData })

function cancelEditing() {
    isEditing.value = false
    if (profileData.value) Object.assign(formData, profileData.value)
}

const { formErrors, generalError, handleApiError } = useFieldErrors()
const loading = ref(false)

async function saveProfile() {
    loading.value = true
    formErrors.value = {}
    generalError.value = null

    try {
        await store.updateProfile(formData)
        showToast('Profilul a fost actualizat cu succes!', 'success')
        isEditing.value = false
    } catch (err) {
        handleApiError(err)
    } finally {
        loading.value = false
    }
}
</script>

<style scoped>
input:hover {
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
}
</style>
