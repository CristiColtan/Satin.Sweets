import { ref } from 'vue'
import { extractApiError } from './apiError.js'

export function useFieldErrors() {
    const formErrors = ref({}) // { title: '...', price: '...' }
    const generalError = ref('')

    function handleApiError(err) {
        const { message, fieldErrors, status } = extractApiError(err)
        formErrors.value = {}
        generalError.value = ''

        if (status === 422 && fieldErrors) {
            for (const [field, msgs] of Object.entries(fieldErrors)) {
                formErrors.value[field] = msgs?.[0] || ''
            }
        } else {
            generalError.value = message
        }
    }

    return { formErrors, generalError, handleApiError }
}
