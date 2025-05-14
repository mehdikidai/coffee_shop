import './assets/main.css'
import '@fontsource/inter'
import '@fontsource/inter/400.css'
import '@fontsource/inter/500.css'
import '@fontsource/inter/600.css'
import '@fontsource/inter/700.css'
import '@splidejs/vue-splide/css';
import 'vue3-toastify/dist/index.css';

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { Icon } from "@iconify/vue";
import Vue3Toastify from 'vue3-toastify';
import XSpace from '@/components/XSpace.vue'
import LayoutApp from '@/components/LayoutApp.vue'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.component('x-icon', Icon)
app.component('x-space', XSpace)
app.component('layout-app', LayoutApp)

app.use(createPinia())
app.use(router)
app.use(Vue3Toastify)

app.mount('#app')
