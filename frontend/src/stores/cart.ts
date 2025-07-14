import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import { type CartProduct } from '@/types/product'
import API from '@/api'

interface History {
  orderId: number
  name: string
  quantity: number
  price: number
  createdAt: string
}

export const useCartStore = defineStore('cart', () => {
  const token = useStorage<string | null>('token', null)
  const tenantToke = useStorage<string | null>('tenantToke', null)
  const cart = useStorage<CartProduct[]>('cart', [])
  const ordersHistory = ref<History[]>([])
  const totalSales = ref<number>(0)
  const loadingHistory = ref(false)
  const totalItemsInHistory = computed(() => ordersHistory.value.length)

  API.interceptors.request.use((config) => {
    const authToken = token.value
    if (authToken) {
      config.headers.Authorization = `Bearer ${authToken}`
    }
    return config
  })

  function addItemToCart(item: CartProduct) {
    const existing = cart.value.find((p) => p.id === item.id)
    if (existing) {
      existing.quantity++
    } else {
      cart.value.push({
        id: item.id,
        name: item.name,
        price: item.price,
        photo: item.photo,
        quantity: 1,
      })
    }
  }

  function removeItemFromCart(itemId: number) {
    cart.value = cart.value.filter((p) => p.id !== itemId)
  }

  function decreaseItemQuantity(itemId: number) {
    const product = cart.value.find((p) => p.id === itemId)
    if (product) {
      product.quantity--
      if (product.quantity <= 0) {
        removeItemFromCart(itemId)
      }
    }
  }

  const totalItems = computed(() => {
    return cart.value.reduce((sum, product) => sum + product.quantity, 0)
  })

  const totalPrice = computed(() => {
    return cart.value.reduce((sum, product) => sum + product.quantity * product.price, 0)
  })

  const resetCart = () => {
    cart.value = []
  }

  const quantityInCart = (id: number) => {
    const product = cart.value.find((item) => item.id === id)
    return product ? Math.min(product.quantity, 99) : 0
  }

  const getOrders = async () => {
    loadingHistory.value = true
    try {
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      const res: any = await API.get('/orders', {
        headers: {
          'X-Tenant-Token': tenantToke.value,
        },
      })
      console.log(res)
      const allOrders = res.data.orders || []
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      const formattedOrders = allOrders.flatMap((order: any) =>
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
        order.items.map((item: any) => ({
          orderId: order.id,
          name: item.product.name,
          quantity: item.quantity,
          price: item.price,
          createdAt: order.created_at,
        })),
      )
      ordersHistory.value = formattedOrders
      totalSales.value = res.data.total_sales
    } catch (error) {
      console.log(error)
    } finally {
      loadingHistory.value = false
    }
  }

  const createOrder = async () => {
    try {
      const res = await API.post(
        '/orders',
        {
          items: cart.value.map((item) => ({
            product_id: item.id,
            quantity: item.quantity,
          })),
        },
        {
          headers: {
            'X-Tenant-Token': tenantToke.value,
          },
        },
      )
      resetCart()
      return res.data
    } catch (error) {
      console.error('Order creation error:', error)
      throw error
    }
  }

  const getInvoice = async (id: number) => {
    try {
      const res = await API.get(`orders/${id}/invoice`, {
        headers: {
          'X-Tenant-Token': tenantToke.value,
        },
      })

      return res.data
    } catch (error) {
      console.log(error)
      throw error
    }
  }

  return {
    cart,
    addItemToCart,
    removeItemFromCart,
    decreaseItemQuantity,
    totalItems,
    totalPrice,
    resetCart,
    quantityInCart,
    createOrder,
    getOrders,
    ordersHistory,
    loadingHistory,
    totalItemsInHistory,
    totalSales,
    getInvoice,
  }
})
