import './bootstrap';


import { createApp } from 'vue';
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

import app from './page/app.vue'
const vuetify = createVuetify({
    components,
    directives
})

import router from './router';

const vue = createApp(app).use(router).use(vuetify)


vue.config.globalProperties.$filters = {
    uppercase(value) {
        if (value) {
            return value[0].toUpperCase() + value.slice(1);
        }
        return value
    }
}

vue.mount('#app')