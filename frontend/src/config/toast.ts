import { Slide, type ToastOptions } from 'vue3-toastify'

export const toastOptions: ToastOptions = {
  position: 'top-center',
  theme: 'dark',
  hideProgressBar: true,
  transition: Slide,
  autoClose: 800,
}
