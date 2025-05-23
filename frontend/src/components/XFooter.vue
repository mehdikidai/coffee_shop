<template>
  <footer>
    <button @click="goTo('/')"><x-icon icon="uil:home-alt" />home</button>
    <button @click="goTo('/history')"><x-icon icon="uil:clipboard-notes" />history</button>
    <button @click="goTo('/profile')"><x-icon icon="uil:user" />profile</button>

  </footer>
</template>

<script setup lang="ts">

import { useRouter } from 'vue-router'
const router = useRouter()

const goTo = (uri: string) => {
  router.push(uri)
}

</script>

<style scoped lang="scss">
footer {
  height: 56px;
  width: 100%;
  max-width: var(--width-app);
  background: var(--background-color-two);
  display: flex;
  align-items: center;
  justify-content: space-around;
  margin: 0 auto;
  padding-inline: 20px;
  button {
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 12px;
    background: transparent;
    border: none;
    color: var(--color-white);
    gap: 2px;
    text-transform: capitalize;
    cursor: pointer;
    opacity: 0.7;
    svg {
      font-size: 20px;
    }
  }
}
</style>
