<script setup lang="ts">
import { RouterView } from 'vue-router'
import XHeader from '@/components/XHeader.vue'
import XMain from '@/components/XMain.vue'
</script>

<template>
  <x-header></x-header>
  <x-main>
    <RouterView />
  </x-main>
</template>

