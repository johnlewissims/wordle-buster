import axios from 'axios';
import { createApp } from 'vue';
import App from './components/App.vue'

window.axios = axios;

createApp(App).mount("#app")
