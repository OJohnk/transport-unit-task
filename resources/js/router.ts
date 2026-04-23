import { createRouter, createWebHistory } from 'vue-router';
import TransportUnits from './pages/TransportUnits.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: TransportUnits },
    ],
});

export default router;