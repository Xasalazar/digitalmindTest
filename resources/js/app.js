import './bootstrap';

import { createApp } from 'vue';
import Router from './routes';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import 'bootstrap-icons/font/bootstrap-icons.css';



const app = createApp({});

app.use(Router);
app.config.productionTip = false;
app.mount('#app');
