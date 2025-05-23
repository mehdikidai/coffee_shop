<template>
  <layout-app>
    <div class="photo_profile">
      <img src="https://avatar.iran.liara.run/public/42" alt="photo_user" />
    </div>
    <span class="span-name">{{ userName }}</span>
    <span class="span-email">{{ userEmail }}</span>
    <button class="btn-logout" @click="handleLogout">logout <x-icon icon="uil:exit" /></button>
  </layout-app>
</template>

<script lang="ts" setup>

import { useUserStore } from '@/stores/user.ts'
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'

const router = useRouter()
const userStore = useUserStore()

const { userName, userEmail } = storeToRefs(userStore)

const handleLogout = () => {
  userStore.logout()
  router.push('/login')
}

</script>

<style lang="scss" scoped>
.photo_profile {
  width: 100px;
  height: 100px;
  background: var(--background-color-two);
  margin: 40px auto 20px;
  clip-path: circle();
  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
}
span {
  background: transparent;
  display: block;
  padding-inline: 20px;
  color: var(--color-white);
  text-align: center;
  &.span-name {
    font-size: 18px;
    margin-bottom: 4px;
    text-transform: capitalize;
  }
  &.span-email {
    text-align: center;
    font-size: 14px;
    opacity: 0.4;
  }
}

.btn-logout {
  background: var(--main-color);
  border: none;
  font-size: 14px;
  padding: 4px 20px;
  margin: 20px auto;
  display: block;
  color: var(--color-white);
  text-transform: capitalize;
  border-radius: 4px;
  cursor: pointer;
  padding: 8px 20px;
  line-height: 1;
  display: flex;
  align-items: center;
  gap: 4px;
  svg {
    font-size: 16px;
  }
}
</style>
