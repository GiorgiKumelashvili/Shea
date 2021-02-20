import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/views/Home.vue';

// Lazy loading
const About = () => import(/* webpackChunkName: "about" */ '@/views/About.vue');
const Register = () => import(/* webpackChunkName: "register" */ '@/views/auth/Register.vue');
const Login = () => import(/* webpackChunkName: "login" */ '@/views/auth/Login.vue');
const Stash = () => import(/* webpackChunkName: "stash" */ '@/views/Stash.vue');
const Board = () => import(/* webpackChunkName: "board" */ '@/views/Board.vue');

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
