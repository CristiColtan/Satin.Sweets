import axiosClient from '../js/axios.js'
async function getUser(params) {
    const response = await axiosClient.get('/user', { params })
    this.user.data = response.data
    return response.data
}

async function login(data) {
    const response = await axiosClient.post('/login', data)
    const responseData = response.data

    this.user.data = responseData.user
    this.user.token = responseData.token

    axiosClient.defaults.headers.common['Authorization'] =
        `Bearer ${responseData.token}`
    localStorage.setItem('token', responseData.token)

    return responseData.user
}

async function logout() {
    console.log('LOGOUT')
    await axiosClient.post('/logout')
    this.user.data = null
    this.user.token = null
    localStorage.removeItem('token')
}

export default {
    getUser,
    login,
    logout,
}
