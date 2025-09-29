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

async function getProducts({
    url = null,
    search = '',
    per_page,
    sort_field,
    sort_direction,
} = {}) {
    this.products.loading = true
    url = url || '/products'

    try {
        const response = await axiosClient.get(url, {
            params: {
                per_page: per_page ?? this.products.limit,
                search,
                sort_field,
                sort_direction,
            },
        })

        const responseData = response.data

        this.products.data = responseData.data
        this.products.links = responseData.links
        this.products.from = responseData.from
        this.products.to = responseData.to
        this.products.page = responseData.current_page
        this.products.limit = responseData.per_page
        this.products.total = responseData.total
    } catch (error) {
        console.error('Error loading products:', error)
    } finally {
        this.products.loading = false
    }
}

async function getProduct(id) {
    try {
        return axiosClient.get(`/products/${id}`)
    } catch (error) {
        console.error('Error fetching product:', error)
        throw error
    }
}

async function deleteProduct(id) {
    try {
        return axiosClient.delete(`/products/${id}`)
    } catch (error) {
        console.error('Error deleting product:', error)
        throw error
    }
}

async function createProduct(product, newImages = []) {
    try {
        const form = new FormData()

        form.append('title', product.title)
        form.append('description', product.description || '')
        form.append('published', product.published ? 1 : 0)
        form.append('price', product.price)

        newImages.forEach((img) => {
            form.append('images[]', img)
        })

        return await axiosClient.post('/products', form, {
            headers: { 'Content-Type': 'multipart/form-data' },
        })
    } catch (error) {
        console.error('Error creating product:', error)
    }
}

async function updateProduct(product, newImages, removedImageIds) {
    console.log('🔹 updateProduct() a primit:', {
        product,
        newImages,
        removedImageIds,
    })

    try {
        const id = product.id

        let payload
        let headers = {}

        if (
            (Array.isArray(product.images) && product.images.length > 0) ||
            (Array.isArray(removedImageIds) && removedImageIds.length > 0) ||
            (Array.isArray(newImages) && newImages.length > 0)
        ) {
            const form = new FormData()

            form.append('id', product.id)
            form.append('title', product.title)
            form.append('description', product.description || '')
            form.append('published', product.published ? 1 : 0)
            form.append('price', product.price)

            newImages.forEach((img, index) => {
                form.append(`images[]`, img)
            })

            removedImageIds.forEach((id) => {
                form.append(`remove_image_ids[]`, id)
            })

            form.append('_method', 'PUT')

            payload = form
            headers['Content-Type'] = 'multipart/form-data'
        } else {
            payload = product
        }

        if (payload instanceof FormData) {
            console.log('🔹 Payload (FormData):')
            for (let [key, value] of payload.entries()) {
                console.log(`${key}:`, value)
            }
        } else {
            console.log('🔹 Payload (JSON):', payload)
        }

        return axiosClient.post(`/products/${id}`, payload, { headers })
    } catch (error) {
        console.error('Error updating product:', error)
        throw error
    }
}
export default {
    getProduct,
    getProducts,
    deleteProduct,
    updateProduct,
    createProduct,
    getUser,
    login,
    logout,
}
