<template>
  <x-header></x-header>
  <x-main>
    <slot></slot>
  </x-main>
  <x-footer></x-footer>
</template>

<script setup lang="ts">
import XHeader from '@/components/XHeader.vue'
import XMain from '@/components/XMain.vue'
import XFooter from '@/components/XFooter.vue';
</script>

<style scoped></style>
