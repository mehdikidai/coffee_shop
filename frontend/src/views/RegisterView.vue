<template>
  <LayoutLogin class="page-register">
    <h1>register now</h1>
    <form method="post" @submit.prevent="handleRegister" autocomplete="off">
      <div class="box">
        <span><x-icon icon="uil:user" /></span>
        <input v-model="name" type="text" name="name" placeholder="Name" />
      </div>
      <div class="box">
        <span><x-icon icon="uil:envelope" /></span>
        <input v-model="email" type="text" name="email" placeholder="Email" />
      </div>
      <div class="box">
        <span><x-icon icon="uil:lock" /></span>
        <input v-model="password" type="password" name="password" placeholder="Password" />
      </div>
      <div class="box">
        <span><x-icon icon="material-symbols:asterisk" /></span>
        <input v-model="password" type="text" name="code" placeholder="Code" />
      </div>
      <div class="box">
        <button type="submit">{{ loading ? 'loading' : 'registration' }}</button>
      </div>
    </form>
  </LayoutLogin>
</template>

<script setup lang="ts">
import LayoutLogin from '@/components/LayoutLogin.vue'
import { ref } from 'vue'

const name = ref<string | null>()
const email = ref<string | null>()
const password = ref<string | null>()
const loading = ref<boolean>(false)

const handleRegister = () => {
  alert('hi')
}
</script>

<style lang="scss" scoped>
@use '@/assets/global' as global;

.page-register {
  h1 {
    @include global.title-login;
  }

  form {
    @include global.form-login;
    .box {
      @include global.form-login-box;
    }
  }
}
</style>
