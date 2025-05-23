<template>
  <layout-login class="page-login">
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
    <x-line v-if="isNativePlatform"></x-line>
    <div class="box-qr" v-if="isNativePlatform">
      <x-icon icon="uil:qrcode-scan" />
      <button @click="startScanning">Scan</button>
    </div>
  </layout-login>
</template>

<script setup lang="ts">
import { useUserStore } from '@/stores/user.ts'
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'
import { ref, onMounted, computed, watch } from 'vue'
import { BarcodeScanner } from '@capacitor-mlkit/barcode-scanning'
import { Capacitor } from '@capacitor/core'
import { Toast } from '@capacitor/toast'
import { LOGIN, KEY } from '@/zod/login'
import LayoutLogin from '@/components/LayoutLogin.vue'

const isSupported = ref<boolean>(false)
const isNativePlatform = computed((): boolean => Capacitor.isNativePlatform())
const keyQrCode = ref<string | null>(null)
const userStore = useUserStore()
const { loading } = storeToRefs(userStore)
const router = useRouter()
const email = ref<string | null>(null)
const password = ref<string | null>(null)

onMounted(async () => {
  isSupported.value = (await BarcodeScanner.isSupported()).supported
})

watch(keyQrCode, async () => {
  const { success, data } = KEY.safeParse(keyQrCode.value)

  if (!success || !data || !keyQrCode.value) return

  try {
    const statusCode = await userStore.loginUserByQrCode(data)
    if (statusCode === 200) router.go(0)
  } catch (error) {
    console.error(error)
    await Toast.show({ text: 'QR code login failed. Please try again.' })
  } finally {
    keyQrCode.value = null
  }
})

const handleLogin = async () => {
  const { success, data } = LOGIN.safeParse({ email: email.value, password: password.value })
  if (!success) return
  try {
    const statusCode = await userStore.loginUser(data.email, data.password)
    if (statusCode === 200) router.go(0)
    console.log(statusCode)
  } catch (error) {
    console.log(error)
    if (isNativePlatform.value) {
      await Toast.show({ text: 'Incorrect password or email' })
    }
  }
}

const startScanning = async () => {
  const granted = await requestPermissions()
  if (!granted) {
    if (isNativePlatform.value) {
      await Toast.show({ text: 'Permission denied' })
    }
    return
  }
  const { barcodes } = await BarcodeScanner.scan()
  const scannedValue = barcodes[0]?.displayValue
  keyQrCode.value = scannedValue
}

const requestPermissions = async () => {
  const { camera } = await BarcodeScanner.requestPermissions()
  return camera === 'granted' || camera === 'limited'
}
</script>

<style scoped lang="scss">

@use '@/assets/global' as global;

.page-login {
  h1 {
    @include global.title-login;
  }
  form {
    @include global.form-login;
    .box {
      @include global.form-login-box;
    }
  }
  .box-qr {
    background: transparent;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    gap: 16px;
    svg {
      font-size: 40px;
      color: var(--color-white);
      opacity: 0.4;
    }
    button {
      background: var(--background-color-two);
      font-size: 14px;
      border: none;
      line-height: 1;
      padding: 8px 24px;
      border-radius: 4px;
      color: var(--color-white);
      font-weight: 600;
    }
  }
}
</style>
