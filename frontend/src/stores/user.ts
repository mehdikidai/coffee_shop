import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import API from '@/api'


export const useUserStore = defineStore('user', () => {
  const token = useStorage<string | null>('token', null)
  const id = useStorage<number | null>('id', null)
  const userName = useStorage<string | null>('userName', null)
  const userEmail = useStorage<string | null>('userEmail', null)
  const table = useStorage<number | null>('table', null)
  const isAuthenticated = computed(() => !!token.value)
  const loading = ref<boolean>(false)

  const loginUser = async (email: string, password: string) => {
    loading.value = true
    try {
      const res = await API.post('/login', { email, password })
      token.value = res.data.token
      id.value = res.data.user.id
      userName.value = res.data.user.name
      table.value = res.data.user.table
      userEmail.value = res.data.user.email
      return 200
    } catch (error) {
      console.log(error)
      throw new Error('Email or password is incorrect')
    } finally {
      loading.value = false
    }
  }

  const loginUserByQrCode = async (key: string) => {
    loading.value = true
    try {
      const res = await API.post('/login/qr', { key: key })
      token.value = res.data.token
      id.value = res.data.user.id
      userName.value = res.data.user.name
      table.value = res.data.user.table
      userEmail.value = res.data.user.email
      return 200
    } catch (error) {
      console.log(error)
      throw new Error('Email or password is incorrect')
    } finally {
      loading.value = false
    }
  }

  const logout = () => {
    token.value = null
    id.value = null
    userName.value = null
    table.value = null
    userEmail.value = null
  }

  return {
    loginUser,
    logout,
    token,
    userName,
    userEmail,
    id,
    table,
    isAuthenticated,
    loading,
    loginUserByQrCode,
  }
})
