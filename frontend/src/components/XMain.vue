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
}
</style>
