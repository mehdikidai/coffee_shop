<template>
  <div class="p-login">
    <div class="photo">
      <img :src="coverLogin" alt="cover login" />
    </div>
    <div class="box-login">
      <h1>welcome back</h1>
      <form method="post" @submit.prevent="handleLogin" autocomplete="off">
        <div class="box">
          <span><x-icon icon="uil:envelope" /></span>
          <input v-model="email" type="text" name="email" id="email" placeholder="Email" />
        </div>
        <div class="box">
          <span><x-icon icon="uil:lock" /></span>
          <input
            v-model="password"
            type="password"
            name="password"
            id="password"
            placeholder="Password"
          />
        </div>
        <div class="box">
          <button type="submit">{{ loading ? 'loading' : 'login' }}</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import coverLogin from '@/assets/imgs/cover-login.jpg'
import { ref } from 'vue'
import { useUserStore } from '@/stores/user.ts'
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'

const userStore = useUserStore()
const { loading } = storeToRefs(userStore)

const router = useRouter()

const email = ref<string | null>(null)
const password = ref<string | null>(null)

const handleLogin = async () => {

  if (!email.value || !password.value) return

  try {
    const statusCode = await userStore.loginUser(email.value, password.value)
    if (statusCode === 200) router.push('/')
    console.log(statusCode)
  } catch (error) {
    console.log(error)
  }
}
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
    padding: 40px 20px 40px;
    overflow-y: auto;
    min-height: 400px;
    h1 {
      line-height: 1;
      color: var(--main-color);
      text-transform: capitalize;
      font-size: 20px;
      margin-bottom: 25px;
    }
    form {
      display: grid;
      gap: 20px;
      .box {
        width: 100%;
        background: var(--background-color-two);
        display: grid;
        grid-template-columns: 40px 1fr;
        height: 40px;
        clip-path: inset(0 round 4px);
        span {
          background: transparent;
          display: flex;
          align-items: center;
          justify-content: center;
          svg {
            color: var(--color-white);
            font-size: 14px;
            opacity: 0.7;
          }
        }
        input {
          border: none;
          background: transparent;
          color: var(--color-white);
          padding-right: 10px;
          &:active,
          &:focus {
            outline: none;
            box-shadow: none;
          }
        }
        button {
          height: 100%;
          background: var(--main-color);
          grid-column: 1/3;
          border: none;
          color: var(--color-white);
          font-size: 14px;
          font-weight: 500;
          text-transform: capitalize;
          cursor: pointer;
        }
      }
    }
  }
}
</style>
