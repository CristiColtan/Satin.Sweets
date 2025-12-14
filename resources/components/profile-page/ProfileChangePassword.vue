<template>
    <div>
        <!--header-->
        <div class="mb-3 flex items-center justify-between">
            <p
                class="font-serif text-2xl font-medium text-gray-900 sm:text-3xl"
            >
                Schimbă parola
            </p>
        </div>

        <div class="space-y-6">
            <div class="flex flex-col items-center justify-center gap-3">
                <form class="flex w-full max-w-md flex-col gap-3">
                    <div class="">
                        <p class="font-serif text-lg">
                            Parolă veche <span class="text-red-600">*</span>
                        </p>
                        <input
                            id="old_password"
                            v-model="formData.old_password"
                            class="focus:ring-rosegold-500 w-full flex-1 rounded border bg-gray-50 hover:ring-1"
                            name="old_password"
                            style="font-size: 15px"
                            type="password"
                            @input="formErrors.old_password = null"
                        />
                        <p
                            v-if="formErrors.old_password"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ formErrors.old_password }}
                        </p>
                    </div>
                    <div class="">
                        <p class="font-serif text-lg">
                            Parolă nouă <span class="text-red-600">*</span>
                        </p>
                        <input
                            id="new_password"
                            v-model="formData.new_password"
                            class="focus:ring-rosegold-500 w-full flex-1 rounded border bg-gray-50 hover:ring-1"
                            name="new_password"
                            style="font-size: 15px"
                            type="password"
                            @input="formErrors.new_password = null"
                        />
                        <p
                            v-if="formErrors.new_password"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ formErrors.new_password }}
                        </p>
                    </div>
                    <div class="">
                        <p class="font-serif text-lg">
                            Confirmă parola <span class="text-red-600">*</span>
                        </p>
                        <input
                            id="confirm_password"
                            v-model="formData.confirm_password"
                            class="focus:ring-rosegold-500 w-full flex-1 rounded border bg-gray-50 hover:ring-1"
                            name="confirm_password"
                            style="font-size: 15px"
                            type="password"
                            @input="formErrors.confirm_password = null"
                        />
                        <p
                            v-if="formErrors.confirm_password"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ formErrors.confirm_password }}
                        </p>
                    </div>
                </form>
                <button
                    :disabled="loading"
                    class="hover:bg-rosegold-700 bg-rosegold-500 rounded border px-3 py-1 text-white sm:px-4"
                    type="button"
                    @click="handleChangePassword"
                >
                    <span class="font-sans text-[15px] sm:text-lg">{{
                        loading ? 'Se salvează..' : 'Salvează'
                    }}</span>
                </button>
                <ErrorAlert :message="generalError" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useFieldErrors } from '../../utils/useFieldErrors.js'
import { useToast } from '../../utils/myToast.js'
import ErrorAlert from '../core/ErrorAlert.vue'
import axiosClient from '../../js/axios.js'

const { formErrors, generalError, handleApiError } = useFieldErrors()
const { showToast } = useToast()

const loading = ref(false)

const formData = reactive({
    old_password: '',
    new_password: '',
    confirm_password: '',
})

function resetForm() {
    formData.old_password = ''
    formData.new_password = ''
    formData.confirm_password = ''
}

async function handleChangePassword() {
    loading.value = true
    formErrors.value = {}
    generalError.value = null

    if (!formData.old_password) {
        formErrors.value.old_password = 'Parola veche este obligatorie.'
        loading.value = false
        return
    }

    if (formData.new_password !== formData.confirm_password) {
        generalError.value = 'Parolele nu coincid.'
        loading.value = false
        return
    }

    try {
        await axiosClient.patch('/change-password', formData)
        showToast('Parola a fost schimbată cu succes!', 'success')
        resetForm()
    } catch (err) {
        handleApiError(err)
    } finally {
        loading.value = false
    }
}
</script>
