import router from './router';

const isLoggedIn = () => localStorage.getItem('isAuthenticated');

router.beforeEach((to, from, next) => {
    if (to.name !== 'register' && to.name !== 'login' && !isLoggedIn()) {
        next({ name: 'login' });
    } else next();
});
