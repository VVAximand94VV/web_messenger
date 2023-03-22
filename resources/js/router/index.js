import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({

    history: createWebHistory(import.meta.env.BASE_URL),


    routes:[
        {
            path:'/',
            component: () => import('../views/main/IndexView.vue'),
            name: 'main.index',
            children:[
                {
                    path:'/',
                    component: () => import('../views/main/chat/Main.vue'),
                    name:'chat.main',
                },
                {
                    path:':id',
                    component: () => import('../views/main/chat/Chat.vue'),
                    name:'chat.single',
                },

            ]
        },
        {
            path:'/signin',
            component: () => import('../views/account/SignIn.vue'),
            name: 'account.signin',
        },
        {
            path:'/signup',
            component: () => import('../views/account/SignUp.vue'),
            name: 'account.signup',
        },
        {
            path:'/forgot',
            component: () => import('../views/account/ForgotPassword.vue'),
            name: 'account.forgot',
        },
        {
            path:'/reset',
            component: () => import('../views/account/PasswordReset.vue'),
            name: 'account.reset',
        },
        {
            path:'/email/:status',
            component: () => import('../views/account/Email.vue'),
            name: 'account.email',
        },
    ]
})

// api / token
router.beforeEach((to, from, next)=>{
    const TOKEN = localStorage.getItem('X-XSRF-TOKEN');

    if(!TOKEN){
        if(to.name==='account.signin' || to.name==='account.signup' || to.name==='account.forgot' || to.name==='account.reset' || to.name==='account.email'){
            return next();
        }else{
            return next({name:'account.signin'});
        }
    }

    if(TOKEN){
        if(to.name==='account.signin' || to.name==='account.signup' || to.name==='account.forgot' || to.name==='account.reset'){
            return next({name:'chat.main'})
        }
    }

    next();
});

export default router;
