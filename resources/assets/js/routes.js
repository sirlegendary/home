import VueRouter from 'vue-router';

let routes = [
    {
        path: '/', redirect: '/login'
    },
    {
        name: 'login',
        path: '/login',
        component: require('./components/pages/Login.vue'),
        meta: {auth: false}
    },
    {
        name: 'home',
        path: '/home',
        component: require('./components/pages/Home.vue'),
        meta: {auth: true}
    },
    {
        name: 'users',
        path: '/users',
        component: require('./components/pages/Users.vue'),
        meta: {auth: true}
    },
    {
        path: '*',
        redirect: '/login'
    }
];

export default new VueRouter({
    routes
});