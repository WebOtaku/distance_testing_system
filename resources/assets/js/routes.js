import VueRouter from 'vue-router';

let routes = [
    {
        path: '/workspace/profile/:userId',
        component: require('./views/Profile')
    },
    {
        path: '/workspace/tests',
        component: require('./views/Tests')
    }
];

export default new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
    linkActiveClass: 'is-active'
});