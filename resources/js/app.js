import axios from 'axios';
import { createApp } from 'vue';
import App from './Components/App.vue'
import '../css/app.css';

window.axios = axios;

createApp(App).mount("#app")
