import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

interface Product {
  id: number
  name: string
  price: number
  quantity: number
}

export const useCartStore = defineStore('cart', () => {

  const cart = ref<Product[]>([])

  function addItemToCart(item: Product) {
    const existing = cart.value.find((p) => p.id === item.id)
    if (existing) {
      existing.quantity++
    } else {
      cart.value.push({
        id: item.id,
        name: item.name,
        price: item.price,
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

  return {
    cart,
    addItemToCart,
    removeItemFromCart,
    decreaseItemQuantity,
    totalItems,
    totalPrice,
    resetCart,
  }
})
