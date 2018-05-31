import "./bootstrap";
import router from "./routes";

import Registration from './components/Registration';
import Errors from './components/Errors';
import vPage from './components/vPage/vPage';
import vTableGrid from './components/vTableGrid/vTableGrid';
import TableGrid from './components/TableGrid';

Vue.component('registration', Registration);
Vue.component('errors', Errors);
Vue.component('vPage', vPage);
Vue.component('vTableGrid', vTableGrid);
Vue.component('TableGrid', TableGrid);

const app = new Vue({
    el: '#app',
    router,

    dataLoad(adapter) {
        if(adapter && typeof(adapter) === 'function')
            vTableGrid.methods.dataLoad = adapter;
            vPage.methods.dataLoad = adapter;
    }
});
