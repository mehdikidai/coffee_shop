<template>
  <header>
    <RouterLink v-if="currentRoute === 'cart'" to="/" class="link-back">
      <x-icon icon="uil:arrow-left" /> back
    </RouterLink>
    <RouterLink v-else to="/"> bee coffee </RouterLink>

    <RouterLink to="/cart" class="link-cart">
      <small>{{ userName || 'guest' }}</small>
      <x-icon icon="uil:store" />
      <span v-if="totalItems > 0" class="total-items">{{ Math.min(totalItems, 99) }}</span>
    </RouterLink>
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
  a {
    color: var(--color-white);
    text-transform: capitalize;
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
      gap: 4px;
      small{
        font-size: 16px;
        font-weight: 400;
        text-transform: lowercase;
        opacity: 0.9;
        pointer-events: none;
        color: var(--main-color);
      }
      .total-items {
        position: absolute;
        background: var(--main-color);
        top: -12px;
        right: -4px;
        font-size: 10px;
        font-weight: 400;
        width: 20px;
        height: 20px;
        clip-path: inset(0 round 10px);
        display: flex;
        align-items: center;
        justify-content: center;
      }
      svg {
        font-size: 22px;
      }
    }
    &.link-back{
      text-transform: lowercase;
    }
  }
}
</style>
