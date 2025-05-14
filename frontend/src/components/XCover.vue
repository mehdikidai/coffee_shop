<template>
  <div class="cover loading" v-if="isLoading">
    <x-icon icon="svg-spinners:bars-rotate-fade"></x-icon>
  </div>
  <div class="cover" v-else>
    <img :src="imgCover" alt="cover" />
    <div class="glass"></div>
    <x-logo height="70px" class="logo"/>
  </div>
</template>

<script setup lang="ts">
import imgCover from '@/assets/imgs/cover.jpg'
import { useImage } from '@vueuse/core'
import XLogo from "@/components/XLogo.vue";

const { isLoading } = useImage({ src: imgCover })
</script>

<style scoped lang="scss">
.cover {
  background: transparent;
  height: 180px;
  position: relative;
  .glass{
    background: rgba(0, 0, 0, 0.05);
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(4px);
  }
  .logo{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
  }
  //clip-path: inset(0 round 0 0 22px 22px);
  &.loading {
    background: var(--background-color-two);
    display: flex;
    align-items: center;
    justify-content: center;
    svg {
      font-size: 24px;
      color: var(--color-white);
    }
  }
  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
}
</style>
