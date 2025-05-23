<template>
  <div class="p-login">
    <div class="photo">
      <img :src="coverLogin" alt="cover login" />
    </div>
    <div class="box-login">
      <div class="btns-switch">
        <RouterLink to="/login"> login </RouterLink>
        <RouterLink to="/register"> register </RouterLink>
      </div>
      <slot></slot>
    </div>
  </div>
</template>

<script setup lang="ts">
import coverLogin from '@/assets/imgs/cover-login.jpg'
</script>

<style scoped lang="scss">
.p-login {
  background: var(--background-color);
  min-height: 100dvh;
  width: 100%;
  max-width: var(--width-app);
  margin: 0 auto;
  position: fixed;
  inset: 0;
  display: flex;
  flex-direction: column;
  .photo {
    height: 110px;
    background: transparent;
    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }
  .box-login {
    background: var(--background-color);
    flex: 1;
    padding: 20px 20px 40px;
    overflow-y: auto;
    min-height: 400px;
    .btns-switch{
      background: transparent;
      margin: 0 0 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      a{
        background: var(--background-color-two);
        padding: 6px 24px;
        border-radius: 4px;
        color: var(--color-white);
        font-size: 14px;
        text-transform: capitalize;
        &.router-link-active{
          background: var(--main-color);
        }
      }
    }
  }
}
</style>
