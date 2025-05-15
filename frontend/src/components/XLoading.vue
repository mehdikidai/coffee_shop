<template>
  <div class="loading-box">
    <x-icon icon="svg-spinners:bars-rotate-fade"></x-icon>
  </div>
</template>

<script setup lang="ts"></script>

<style scoped lang="scss">
.loading-box {
  min-height: 260px;
  display: flex;
  align-items: center;
  justify-content: center;
  svg {
    color: var(--color-white);
    font-size: 20px;
    opacity: 0.5;
  }
}
</style>
