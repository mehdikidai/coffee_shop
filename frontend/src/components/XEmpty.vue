<template>
  <div class="empty">
    <x-icon :icon="icon" />
    <span>{{ message }}</span>
  </div>
</template>

<script setup lang="ts">
const { message, icon } = defineProps<{ message: string; icon: string }>()
</script>

<style scoped lang="scss">
.empty {
  background: var(--background-color);
  height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 10px;
  color: var(--color-white);
  svg {
    font-size: 40px;
    opacity: 0.7;
    color: var(--main-color);
  }
  span {
    font-size: 16px;
    font-weight: 400;
    opacity: 0.7;
    text-transform: capitalize;
  }
}
</style>
