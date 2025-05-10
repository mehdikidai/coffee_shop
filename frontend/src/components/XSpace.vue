<template>
  <div class="space" :style="{ height: `${height}px` }"></div>
</template>

<script setup lang="ts">
const { height } = defineProps<{ height: number }>()
</script>
