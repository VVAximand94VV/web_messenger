import './bootstrap';
import { createApp } from "vue";
import App from './App.vue';
import router from './router'
import store from './store';
// import { useVuelidate } from '@vuelidate/core'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import { createI18n } from 'vue-i18n';
import { defaultLocale, languages } from './locales/index';

const messages = Object.assign(languages);
const i18n = createI18n({
    legacy:false,
    locale: defaultLocale,
    fallbackLocale:'en',
    messages,
  })


const app = createApp(App);
app.use(router);
app.use(store);
app.use(i18n);

const toastOptions = {
    position: "top-right",
    timeout: 5000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: true,
    closeButton: "button",
    icon: true,
    rtl: false
};
app.use(Toast, toastOptions);

// app.use(useVuelidate);
app.mount('#app');


