import {createRouter , createWebHistory }from "vue-router";
import productIndex from '../Components/products/index.vue';
import notFound from '../Components/NotFound.vue';

const routes=[
    {
        path:'/',
        component:productIndex
    },
    
    {
        path:'/:pathMatch(.*)*',
        component:notFound
    }
    
]
const router=createRouter({
    history:createWebHistory(),
    routes
})
export default router