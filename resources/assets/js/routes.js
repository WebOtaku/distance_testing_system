import VueRouter from 'vue-router';

let routes = [
    {
        path: '/workspace/profile/:userId',
        component: require('./views/Profile')
    },
    {
        path: '/workspace/tests',
        component: require('./views/Tests')
    },
    {
        path: '/workspace/tests/create',
        component: require('./components/Test/Create')
    },
    {
        path: '/workspace/tests/workspace/:testId',
        component: require('./components/Test/Workspace')
    }
];

export default new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
    linkActiveClass: 'is-active'
});