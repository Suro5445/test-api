import { createRouter, createWebHistory } from 'vue-router';
import AdsList from "./../components/AdsList.vue";
import CreateAd from './../components/CreateAd.vue';
import AdDetail from './../components/AdDetail.vue';

const routes = [
    { path: '/', component: AdsList, name: 'ads-list' },
    { path: '/create', component: CreateAd, name: 'create-ad' },
    { path: '/ad/:id', component: AdDetail, name: 'ad-detail' },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
