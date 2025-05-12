<template>
  <footer>
    <!-- <button><x-icon icon="uil:user" />{{ userName }}</button> -->
    <button @click="handleLogout"><x-icon icon="uil:exit" />logout</button>
  </footer>
</template>

<script setup lang="ts">
import { useUserStore } from '@/stores/user.ts'
import { useRouter } from 'vue-router'

const router = useRouter()
const userStore = useUserStore()

const handleLogout = () => {
  userStore.logout()
  router.push('/login')
}
</script>

<style scoped lang="scss">
footer {
  height: 40px;
  width: calc(100% - 40px);
  max-width: var(--width-app);
  background: var(--main-color);
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 auto;
  clip-path: inset(0 round 6px);
  button {
    color: var(--color-white);
    font-size: 14px;
    text-transform: capitalize;
    background: transparent;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
}
</style>
