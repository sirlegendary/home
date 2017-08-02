import VueRouter from 'vue-router';

let routes = [
    {
        path: '/', redirect: '/home'
    },
    {
        name: 'home',
        path: '/home',
        component: require('./components/pages/Home.vue')
    },
    {
        name: 'users',
        path: '/users',
        component: require('./components/pages/Users.vue')
    },
    {
        path: '*',
        redirect: '/home'
    }
];

export default new VueRouter({
    routes
});