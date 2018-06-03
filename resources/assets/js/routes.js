import VueRouter from 'vue-router';

let routes = [
    {
        path: '/workspace',
        redirect: '/workspace/tests/'
    },
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
    },
    {
        path: '/workspace/themes',
        component: require('./views/Themes')
    },
    {
        path: '/workspace/themes/create',
        component: require('./components/Theme/Create')
    },
    {
        path: '/workspace/themes/edit/:themeId',
        component: require('./components/Theme/Edit')
    }
];

export default new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
    linkActiveClass: 'is-active'
});