import "./bootstrap";
import router from "./routes";

import Registration from './components/Registration';
import Errors from './components/Errors';
import vPage from './components/vPage/vPage';

Vue.component('registration', Registration);
Vue.component('errors', Errors);
Vue.component('vPage', vPage);

const app = new Vue({
    el: '#app',
    router
});
