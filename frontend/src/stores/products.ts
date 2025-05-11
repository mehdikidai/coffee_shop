import { ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { type Product, type Categories } from '@/types/product'

const apiUri = import.meta.env.VITE_API_URI

export const useProductsStore = defineStore('products', () => {
  const products = ref<Product[]>([])
  const categories = ref<Categories[]>([])

  const loading = ref(false)
  const loadingCategories = ref(false)

  const categoriesFetched = ref<boolean>(false)

  const fetchProducts = async (categoryId: number | null = null) => {
    loading.value = true
    try {
      const baseURL = `${apiUri}/products`
      const url = categoryId ? `${baseURL}?categoryId=${categoryId}` : baseURL
      const res = await axios.get(url)
      products.value = res.data
      console.log(res)
    } catch (error) {
      console.error(error)
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
      const baseURL = `${apiUri}/categories`
      const res = await axios.get(baseURL)
      categories.value = res.data
      categoriesFetched.value = true
      console.log(res)
    } catch (error) {
      console.error(error)
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
