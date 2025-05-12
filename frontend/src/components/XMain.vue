<template>
  <main>
    <slot></slot>
  </main>
</template>

<script setup lang="ts"></script>

<style scoped lang="scss">
main {
  padding-bottom: 20px;
  min-height: calc(100dvh - 60px);
}
</style>
