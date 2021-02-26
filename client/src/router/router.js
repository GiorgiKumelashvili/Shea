import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/views/Home.vue';

// Lazy loading
const About = () => import(/* webpackChunkName: "About" */ '@/views/About.vue');
const Register = () => import(/* webpackChunkName: "Register" */ '@/views/auth/Register.vue');
const Login = () => import(/* webpackChunkName: "Login" */ '@/views/auth/Login.vue');
const Stash = () => import(/* webpackChunkName: "Stash" */ '@/views/Stash.vue');
const Board = () => import(/* webpackChunkName: "Board" */ '@/views/Board.vue');
const Archive = () => import(/* webpackChunkName: "Archive" */ '@/views/Archive.vue');

const auth = redirect => {
    const isAuthenticated = localStorage.getItem('isAuthenticated') ?? false;
    if (isAuthenticated) redirect({ name: 'home' });
    else redirect();
};

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/about',
        name: 'about',
        component: About
    },
    {
        path: '/stash',
        name: 'stash',
        component: Stash
    },
    {
        path: '/board',
        name: 'board',
        component: Board
    },
    {
        path: '/archive',
        name: 'archive',
        component: Archive
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        beforeEnter: (to, from, next) => auth(next)
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter: (to, from, next) => auth(next)
    }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

export default router;
