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
        path: '/workspace/tests/edit/:testId',
        component: require('./components/Test/Edit')
    },
    {
        path: '/workspace/tests/edit/:testId/question',
        component: require('./components/Question')
    }
];

export default new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
    linkActiveClass: 'is-active'
});