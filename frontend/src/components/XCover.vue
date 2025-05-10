<template>
  <div class="cover">
    <img :src="imgCover" alt="cover" />
  </div>
</template>

<script setup lang="ts">
import imgCover from '@/assets/imgs/cover.jpg'
</script>

<style scoped lang="scss">
.cover {
  background: transparent;
  height: 200px;
  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
}
</style>
