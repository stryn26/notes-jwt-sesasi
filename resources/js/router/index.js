import { createRouter, createWebHistory } from 'vue-router';

// Define routes
const routes = [
    {
        path: '/',
        name: 'notes.login',
        component: () => import(/* webpackChunkName: "login" */ '../views/login.vue')
    },
    {
        path: '/notes-user',
        name: 'notes.home.user',
        component: () => import(/* webpackChunkName: "home" */ '../views/notes/home_user.vue')
    },
    {
        path: '/notes',
        name: 'notes.home',
        component: () => import(/* webpackChunkName: "home" */ '../views/notes/home.vue')
    },
    {
        path: '/note/:id',
        name: 'notes.show',
        component: () => import(/* webpackChunkName: "show" */ '../views/notes/showNote.vue')
    },
    {
        path: '/create',
        name: 'notes.create',
        component: () => import(/* webpackChunkName: "create" */ '../views/notes/createNote.vue')
    },
    {
        path: '/edit/:id',
        name: 'notes.edit',
        component: () => import(/* webpackChunkName: "edit" */ '../views/notes/editNote.vue')
    }
];

// Create router
const router = createRouter({
    history: createWebHistory(),
    routes // <-- Use the 'routes' array here
});

export default router;