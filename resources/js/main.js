import { createApp } from 'vue'
import {createRouter, createWebHashHistory} from 'vue-router'
import App from './App.vue'
import CreateOrder from './components/tabs/CreateOrder.vue'
import ListOrders from './components/tabs/ListOrders.vue'

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {path: '/', component: CreateOrder},
    {path: '/create-order', component: CreateOrder},
    {path: '/list-orders', component: ListOrders},
  ],
})
createApp(App)
  .use(router)
  .mount('#app')
