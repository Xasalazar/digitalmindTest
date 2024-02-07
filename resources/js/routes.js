import { createWebHistory, createRouter } from 'vue-router'

//const ForgotPassword = () => import('./views/ForgotPassword.vue')

const routes =  [
    {
        path: "/",
        name: "Usuario-Index",
        component: () => import("@/views/Usuarios/Index.vue"),
        meta: {
            title: 'Lista de Usuarios'
        }
    },
    {
        path: "/Nuevo",
        name: "Usuario-Form",
        component: () => import("@/views/Usuarios/Form.vue"),
        meta: {
            title: 'Create de Usuarios'
        }
    },
    {
        path: "/Editar/:id_usuario",
        name: "Usuario-Edit",
        component: () => import("@/views/Usuarios/Form.vue"),
        meta: {
            title: 'Edit de Usuarios'
        }
    },


]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
