import { reactive } from 'vue'

const toastState = reactive({
    show: false,
    message: '',
    type: 'success',
})

export function useToastState() {
    return toastState
}

export function useToast() {
    const showToast = (message, type = 'success', duration = 4000) => {
        toastState.message = message
        toastState.type = type
        toastState.show = true
        setTimeout(() => {
            toastState.show = false
        }, duration)
    }

    return { showToast }
}
