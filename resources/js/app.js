import { createApp } from 'vue'
import { createPinia } from 'pinia'
import '@sts/funky-ui-kit/dist/funky-ui-kit.css'
import funkyUIKitPlugin from '@sts/funky-ui-kit'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

import './bootstrap'
import '../css/app.css'
import { router } from '@/router'
import App from '../App.vue'

import { addIcons, OhVueIcon } from 'oh-vue-icons'
import {
    BiBoxSeam,
    BiHourglassSplit,
    CoOpenstreetmap,
    MdSupportagent,
} from 'oh-vue-icons/icons'

addIcons(MdSupportagent, CoOpenstreetmap, BiHourglassSplit, BiBoxSeam)

const app = createApp(App)
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

app.use(pinia)
app.use(router)
app.use(funkyUIKitPlugin)
app.component('v-icon', OhVueIcon)
app.mount('#app')
