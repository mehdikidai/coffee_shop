<template>
  <header>
    <RouterLink v-if="currentRoute === 'cart'" to="/" class="link-back">
      <x-icon icon="uil:arrow-left" /> back
    </RouterLink>
    <RouterLink v-else to="/"> bee coffee </RouterLink>

    <div class="btns">
      <RouterLink to="/cart" class="link-cart">
        <small>{{ userName || 'guest' }}</small>
        <x-icon icon="uil:store" />
        <span v-if="totalItems > 0" class="total-items">{{ Math.min(totalItems, 99) }}</span>
      </RouterLink>
      <!-- <button class="btn-logout" @click="handleLogout"><x-icon icon="uil:exit" /></button> -->
    </div>
  </header>
</template>

<script setup lang="ts">

import { RouterLink } from 'vue-router'
import { useCartStore } from '@/stores/cart'
import { useUserStore } from '@/stores/user'
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'
import { computed } from 'vue'


const router = useRouter()
const currentRoute = computed(() => router.currentRoute.value.name)
const cartStore = useCartStore()
const userStore = useUserStore()
const { totalItems } = storeToRefs(cartStore)
const { userName } = storeToRefs(userStore)

// const handleLogout = () => {
//   userStore.logout()
//   router.push('/login')
// }


</script>

<style scoped lang="scss">
header {
  background: var(--background-color-two);
  height: 60px;
  margin: 0 auto;
  padding-inline: 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky;
  top: 0;
  z-index: 99;
  .btns {
    display: flex;
    align-items: center;
    gap: 12px;
    button {
      background: transparent;
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      cursor: pointer;
      svg {
        font-size: 20px;
        color: var(--color-white);
      }
    }
  }
  a {
    color: var(--color-white);
    text-transform: uppercase;
    font-weight: 600;
    font-size: 18px;
    &.link-cart,
    &.link-back {
      //background: #2c3b3f;
      width: fit-content;
      height: fit-content;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      gap: 8px;
      small {
        font-size: 16px;
        font-weight: 400;
        text-transform: lowercase;
        pointer-events: none;
        color: var(--color-white);
      }
      .total-items {
        position: absolute;
        background: var(--main-color);
        top: -12px;
        right: -4px;
        font-size: 10px;
        font-weight: 400;
        width: 18px;
        height: 18px;
        clip-path: inset(0 round 10px);
        display: flex;
        align-items: center;
        justify-content: center;
      }
      svg {
        font-size: 20px;
      }
    }
    &.link-back {
      text-transform: lowercase;
    }
  }
}
</style>
