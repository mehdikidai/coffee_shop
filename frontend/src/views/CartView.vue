<template>
  <layout-app>
    <div v-if="cart.length > 0" class="container">
      <x-space :height="20"></x-space>
      <TransitionGroup name="list" tag="div" class="list-items">
        <div class="item" v-for="item in cart" :key="item.id">
          <div class="box photo">
            <img :src="CupImg" :alt="item.name" />
          </div>
          <div class="box info">
            <span class="name-p">{{ item.name }}</span>
            <span class="total-p"
              >{{ item.price }} {{ currency }} <small>x</small> {{ item.quantity }} =
              <strong>{{ item.price * item.quantity }} {{ currency }}</strong>
            </span>
            <div class="actions">
              <button @click="decreaseItemQuantity(item.id)" :disabled="item.quantity === 1">
                <x-icon icon="uil:minus" />
              </button>
              <button @click="increaseItemQuantity(item)">
                <x-icon icon="uil:plus" />
              </button>
              <button @click="removeItemFromCart(item.id)">
                <x-icon icon="uil:trash-alt" />
              </button>
            </div>
          </div>
        </div>
      </TransitionGroup>
      <x-line></x-line>
      <div class="total">
        <span>total :</span> <span>{{ totalPrice.toFixed(2) }} {{ currency }}</span>
      </div>
      <x-line></x-line>

      <button v-if="loading" class="checkout" :disabled="loading">loading ...</button>
      <button v-else class="checkout" @click="sendData" :disabled="loading">checkout</button>

      <x-space :height="40"></x-space>
    </div>
    <x-empty v-else message="Your cart is currently empty" icon="uil:shopping-basket"></x-empty>
  </layout-app>
</template>

<script setup lang="ts">
import { useCartStore } from '@/stores/cart'
import { storeToRefs } from 'pinia'
import CupImg from '@/assets/imgs/cup-test.jpg'
import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import moment from 'moment'
import { toast } from 'vue3-toastify'
import { toastOptions } from '@/config/toast'
import { useUserStore } from '@/stores/user.ts'
import { generateOrderId } from '@/helper'
import XEmpty from '@/components/XEmpty.vue'

const userStore = useUserStore()

const router = useRouter()
const currency = import.meta.env.VITE_CURRENCY
const cartStore = useCartStore()
const { cart, totalPrice } = storeToRefs(cartStore)
const { decreaseItemQuantity, removeItemFromCart, addItemToCart } = cartStore
const loading = ref<boolean>(false)

const tokenSheetDb = import.meta.env.VITE_TOKEN_SHEETDB
const uriSheetDb = import.meta.env.VITE_SHEETDB_URI

const increaseItemQuantity = (item: (typeof cart.value)[number]) => {
  addItemToCart(item)
}

const sendData = async () => {
  const orderId = generateOrderId()
  const today = moment().format('L')
  const hour = moment().format('HH:mm:ss')

  loading.value = true

  try {
    for (const item of cart.value) {
      await axios.post(
        uriSheetDb,
        {
          id: 'INCREMENT',
          order_id: orderId,
          customer: userStore.userName,
          customer_id: userStore.id,
          date: today,
          time: hour,
          name: item.name,
          price: item.price,
          quantity: item.quantity,
          total: `${item.price * item.quantity}`,
        },
        {
          headers: {
            Authorization: `Bearer ${tokenSheetDb}`,
          },
        },
      )
    }

    await cartStore.createOrder()

    toast.success(`It's done`, {
      ...toastOptions,
      onClose: () => router.push('/'),
    })
  } catch (error) {
    console.error('Failed to send to Google Sheets:', error)
  } finally {
    loading.value = false
  }
}
</script>

<style scoped lang="scss">
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(200px);
}

.container {
  padding-inline: 15px;
  .list-items {
    display: grid;
    gap: 15px;
    overflow-x: hidden;
    .item {
      height: 120px;
      background: var(--background-color-two);
      border-radius: 6px;
      color: var(--color-white);
      display: grid;
      grid-template-columns: 100px 1fr;
      gap: 0;
      align-content: center;
      padding-inline: 10px;
      .box {
        background: rgba(255, 255, 255, 0.1);
        height: 100px;
        &.photo {
          clip-path: inset(0 round 2px);
          aspect-ratio: 1;
          display: flex;
          img {
            width: 100%;
            height: 100%;
            object-fit: cover;
          }
        }
        &.info {
          padding: 0 0 0 15px;
          display: flex;
          flex-direction: column;
          gap: 10px;
          background: transparent;
          align-content: start;
          .name-p {
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
          }
          .total-p {
            opacity: 1;
            font-size: 14px;
            text-transform: capitalize;
            flex: 1;
            strong {
              color: var(--main-color);
            }
            small {
              text-transform: lowercase;
              padding-inline: 2px;
              color: var(--main-color);
            }
          }
          .actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            button {
              width: 28px;
              height: 28px;
              border-radius: 6px;
              border: none;
              background: var(--main-color);
              background: #384f51;
              color: var(--color-white);
              display: flex;
              align-items: center;
              justify-content: center;
              cursor: pointer;
              &:disabled {
                opacity: 0.2;
                pointer-events: none;
              }
            }
          }
        }
      }
    }
  }
  .total {
    background: var(--background-color-two);
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    padding: 12px 20px;
    border-radius: 6px;
    span {
      font-size: 18px;
      color: var(--color-white);
      text-transform: capitalize;
      font-weight: 600;
    }
  }

  .checkout {
    background: var(--main-color);
    border: none;
    width: 100%;
    margin: 0 auto;
    display: flex;
    height: 45px;
    align-items: center;
    justify-content: center;
    color: var(--color-white);
    border-radius: 6px;
    font-size: 16px;
    text-transform: capitalize;
    cursor: pointer;
  }
}
</style>
