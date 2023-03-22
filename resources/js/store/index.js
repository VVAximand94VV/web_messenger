import { createStore } from 'vuex';
import application from './modules/application';
import user from './modules/user';

const store = createStore({
    modules:{
        application,
        user,
    }
});

export default store;