import router from '../../router/index.js'
import store from '../index';

export default {

    actions:{
        async logout({dispatch}){
            // axios.get('/sanctum/csrf-cookie').then(result => {
                await axios.post('/api/auth/logout',{}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                    }
                })
                    .then(res => {
                        router.push({name:'account.signin'});
                        //console.log(res);
                        localStorage.removeItem('X-XSRF-TOKEN');
                        localStorage.removeItem('user_info');
                        store.dispatch('changeSidebar')
                    })
                    .catch(error => {
                        console.log(error);
                    })
            // })
        }        
    }
}