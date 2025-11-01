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

        Object.assign(this.products, {
            data: Array.isArray(responseData.data)
                ? responseData.data
                : Object.values(responseData.data),
            links: responseData.links,
            from: responseData.from,
            to: responseData.to,
            page: responseData.current_page,
            limit: responseData.per_page,
            total: responseData.total,
        })
    } catch (error) {
        console.error('Error fetching products:', error)
        throw error
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
    console.log('🔹 createProduct() a primit:', {
        product,
        newImages,
    })

    try {
        const form = new FormData()

        form.append('title', product.title)
        form.append('description', product.description || '')
        form.append('published', product.published ? 1 : 0)
        form.append('price', product.price)

        form.append(
            'discounted_price',
            product.discounted_price !== null &&
                product.discounted_price !== undefined &&
                product.discounted_price !== ''
                ? product.discounted_price
                : '',
        )

        form.append('badge', product.badge || '')

        if (Array.isArray(product.categories) && product.categories.length > 0)
            product.categories.forEach((catId) => {
                form.append('categories[]', catId)
            })

        if (product.additional_info) {
            form.append(
                'additional_info',
                JSON.stringify(product.additional_info),
            )
        }

        newImages.forEach((img) => {
            form.append('images[]', img)
        })

        return await axiosClient.post('/products', form, {
            headers: { 'Content-Type': 'multipart/form-data' },
        })
    } catch (error) {
        console.error('Error creating product:', error)
        throw error
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
            form.append('badge', product.badge || '')

            form.append(
                'discounted_price',
                product.discounted_price !== null &&
                    product.discounted_price !== undefined &&
                    product.discounted_price !== ''
                    ? product.discounted_price
                    : '',
            )

            if (
                Array.isArray(product.categories) &&
                product.categories.length > 0
            )
                product.categories.forEach((catId) => {
                    form.append('categories[]', catId)
                })

            if (product.additional_info) {
                form.append(
                    'additional_info',
                    JSON.stringify(product.additional_info),
                )
            }

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

        if (payload instanceof FormData) {
            return axiosClient.post(`/products/${id}`, payload, { headers })
        } else return axiosClient.put(`/products/${id}`, payload)
    } catch (error) {
        console.error('Error updating product:', error)
        throw error
    }
}

async function getAddons({
    url = null,
    search = '',
    per_page,
    sort_field,
    sort_direction,
    type = 'glitters',
} = {}) {
    if (!this.addons[type]) {
        console.warn(`Unknown addon type: ${type}`)
        return
    }
    const addonState = this.addons[type]
    addonState.loading = true
    url = url || '/addons'

    try {
        const response = await axiosClient.get(url, {
            params: {
                per_page: per_page ?? addonState.limit,
                search,
                sort_field,
                sort_direction,
                type,
            },
        })
        const responseData = response.data

        Object.assign(addonState, {
            data: Array.isArray(responseData.data)
                ? responseData.data
                : Object.values(responseData.data),
            links: responseData.links,
            from: responseData.from,
            to: responseData.to,
            page: responseData.current_page,
            limit: responseData.per_page,
            total: responseData.total,
        })
    } catch (error) {
        console.error('Error loading addons:', error)
        throw error
    } finally {
        addonState.loading = false
    }
}

async function getAddon(id) {
    try {
        return axiosClient.get(`/addons/${id}`)
    } catch (error) {
        console.error('Error fetching addon:', error)
        throw error
    }
}

async function deleteAddon(id) {
    try {
        return axiosClient.delete(`/addons/${id}`)
    } catch (error) {
        console.error('Error deleting addon:', error)
        throw error
    }
}

async function createAddon(addon, newImages) {
    console.log('Create Addon a primit:', addon)

    try {
        const form = new FormData()

        form.append('name', addon.name)
        form.append('description', addon.description || '')
        form.append('hex_code', addon.hex_code)
        form.append('price', addon.price)
        form.append('type', addon.type)
        form.append('is_active', addon.is_active ? 1 : 0)

        if (Array.isArray(newImages) && newImages.length > 0) {
            newImages.forEach((img) => {
                form.append('images[]', img)
            })
        }

        if (Array.isArray(addon.categories) && addon.categories.length > 0)
            addon.categories.forEach((cat, i) => {
                const id = typeof cat === 'object' ? cat.id : cat
                form.append(`categories[${i}]`, id)
            })

        return await axiosClient.post('/addons', form, {
            headers: { 'Content-Type': 'multipart/form-data' },
        })
    } catch (error) {
        console.error('Error creating addon:', error)
        throw error
    }
}

async function updateAddon(addon, newImages) {
    console.log('Update Addon a primit:', addon)
    try {
        const id = addon.id
        let payload
        let headers = {}

        const form = new FormData()
        form.append('name', addon.name)
        form.append('description', addon.description || '')
        form.append('hex_code', addon.hex_code)
        form.append('price', addon.price)
        form.append('type', addon.type)
        form.append('is_active', addon.is_active ? 1 : 0)

        if (Array.isArray(newImages) && newImages.length > 0) {
            newImages.forEach((img) => {
                form.append('images[]', img)
            })
        }

        if (Array.isArray(addon.categories) && addon.categories.length > 0)
            addon.categories.forEach((cat, i) => {
                const id = typeof cat === 'object' ? cat.id : cat
                form.append(`categories[${i}]`, id)
            })

        form.append('_method', 'PUT')
        payload = form
        headers['Content-Type'] = 'multipart/form-data'

        return await axiosClient.post(`/addons/${id}`, payload, { headers })
    } catch (error) {
        console.error('Error updating addon:', error)
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
    getAddon,
    getAddons,
    deleteAddon,
    createAddon,
    updateAddon,
    login,
    logout,
}
