<script setup lang="ts">
import { RouterView } from 'vue-router'
import XHeader from '@/components/XHeader.vue'
</script>

<template>
  <x-header></x-header>
  <main>
    <RouterView />
  </main>
</template>

<style scoped lang="scss"></style>
