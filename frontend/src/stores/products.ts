import { ref } from 'vue'
import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import { type Product, type Categories } from '@/types/product'
import API from '@/api'

export const useProductsStore = defineStore('products', () => {

  const token = useStorage<string | null>('token', null)
  const products = ref<Product[]>([])
  const categories = ref<Categories[]>([])
  const loading = ref(false)
  const loadingCategories = ref(false)
  const categoriesFetched = ref<boolean>(false)



  API.interceptors.request.use((config) => {
    const authToken = token.value
    if (authToken) {
      config.headers.Authorization = `Bearer ${authToken}`
    }
    return config
  })


  const fetchProducts = async (categoryId: number | null = null) => {
    loading.value = true
    try {
      const baseURL = `/products`
      const url = categoryId ? `/categories/${categoryId}/products` : baseURL
      const res = await API.get(url)
      products.value = res.data
      console.log(res)
    } catch (error) {
      console.log(error)
    } finally {
      setTimeout(() => {
        loading.value = false
      }, 500)
    }
  }

  const fetchCategories = async () => {
    if (categoriesFetched.value) return

    loadingCategories.value = true

    try {
      const res = await API.get('/categories')
      categories.value = res.data
      categoriesFetched.value = true
      console.log(res)
    } catch (error) {
      console.log(error)
    } finally {
      loadingCategories.value = false
    }
  }

  return {
    products,
    loading,
    fetchProducts,
    loadingCategories,
    categories,
    fetchCategories,
  }
})
