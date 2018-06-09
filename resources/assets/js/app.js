import "./bootstrap";
import router from "./routes";

import Registration from './components/Registration';
import Login from './components/Login';
import Errors from './components/Errors';
import vPage from './components/vPage/vPage';
import TableGrid from './components/TableGrid';

Vue.component('registration', Registration);
Vue.component('login', Login);
Vue.component('errors', Errors);
Vue.component('vPage', vPage);
Vue.component('TableGrid', TableGrid);

const app = new Vue({
    el: '#app',
    router,

    methods: {
        openNavBurger($event) {
            if ($event.target.classList.contains('is-active')) {
                $event.target.classList.remove('is-active');
                this.$refs.main_menu.classList.remove('is-active');
            }
            else {
                $event.target.classList.add('is-active');
                this.$refs.main_menu.classList.add('is-active');
            }
        }
    },

    dataLoad(adapter) {
        if(adapter && typeof(adapter) === 'function')
            TableGrid.methods.dataLoad = adapter;
            vPage.methods.dataLoad = adapter;
    }
});
