import "./bootstrap";
import router from "./routes";

import Registration from './components/Registration';

Vue.component('registration', Registration);

const app = new Vue({
    el: '#app',
    router
});
