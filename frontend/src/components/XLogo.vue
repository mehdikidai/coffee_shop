<template>
  <div class="logo">
    <img :src="logoApp" alt="logo app" :height="height" />
  </div>
</template>

<script setup lang="ts">
import logoApp from '@/assets/imgs/logo-bee-coffee.svg'

const { height } = defineProps<{ height: string }>()
</script>

<style scoped lang="scss">
.logo {
  display: flex;
  align-items: center;
  width: fit-content;
  height: fit-content;
}
</style>
