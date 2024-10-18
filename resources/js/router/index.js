import { createRouter, createWebHistory } from "vue-router";

import login from "../page/login/index.vue";
import todo from "../page/todo/index.vue";
import register from "../page/register/index.vue";
import notFound from "../page/pagenotfound.vue";

const routes = [
    {
        path: "/",
        name: "login",
        component: login
    },
    {
        path: "/login",
        name: "logins",
        component: login
    },

    {
        path: "/register",
        name: "register",
        component: register
    },
    {   
        path: "/todo",  
        name: "todo",
        component: todo
    },
    {
        path: "/:pathMatch(.*)*",
        name: "page-not-found",
        component: notFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router