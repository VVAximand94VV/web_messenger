import axios from "axios";
import router from "../router";

const api = axios.create();


api.interceptors.response.use({}, error => {
    if(error.response.status === 401 || error.response.status === 419){
        const TOKEN = localStorage.getItem('X-XSRF-TOKEN');
        if(TOKEN){
            localStorage.removeItem('X-XSRF-TOKEN');
        }
        router.push({name:'account.signin'});
    }
})

export default api;
