import axios from 'axios'

const axiosClient = axios.create({
    baseURL: 'http://testproj.valet/api',
})

axiosClient.interceptors.request.use((config) => {
    const token = localStorage.getItem('token')
    if (token) {
        config.headers.Authorization = `Bearer ${token}`
    }
    return config
})

axiosClient.interceptors.response.use(
    (response) => response,
    async (error) => {
        const { status } = error?.response || {}

        // (Opțional) Un mic retry doar la erori de rețea (fără status)
        // Evită retry pe POST idempotent? Tu decizi; implicit nu retry pe POST.
        if (!status) {
            const cfg = error.config || {}
            cfg.__retryCount = cfg.__retryCount || 0
            if (cfg.__retryCount < 1 && cfg.method !== 'post') {
                cfg.__retryCount += 1
                await new Promise((r) => setTimeout(r, 500))
                return axiosClient(cfg)
            }
        }

        // 401: scoate token + redirect la login (dacă vrei)
        //if (status === 401) {
        //localStorage.removeItem('token')
        // de exemplu, poți emite un event global sau redirecționa:
        // window.location.href = '/login'
        //}

        // IMPORTANT: nu "înghiți" eroarea — propag-o, ca să poți controla în componentă
        return Promise.reject(error)
    },
)
export default axiosClient
