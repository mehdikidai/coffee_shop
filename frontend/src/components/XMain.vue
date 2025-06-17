<template>
  <main>
    <slot></slot>
  </main>
</template>

<script setup lang="ts"></script>

<style scoped lang="scss">
main {
  height: calc(100dvh - 116px);
  overflow-y: auto;
  &::-webkit-scrollbar {
    width: var(--sb-size);
  }

  &::-webkit-scrollbar-track {
    background: var(--sb-track-color);
  }

  &::-webkit-scrollbar-thumb {
    background: var(--sb-thumb-color);
  }
}
</style>
