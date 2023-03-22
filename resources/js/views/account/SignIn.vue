<template>
    <section class="content h-100">

            <div class="row h-100 py-5">

                <div class="col-md-12 my-auto">

                    <div class="card mx-auto my-auto" id="loginForm" style="border-radius: 15px; max-width: 600px">

                        <div class="card-body">

                            <div class="row mt-3">

                                <div class="col-12 mb-4 mb-md-0">

                                    <h2 class="text-center">{{ $t('signin.title') }}</h2>

                                    <form class="login-form">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ $t('signin.email') }}</label>
                                            <div class="input-group has-validation">
                                                <input @blur="v$.loginForm.email.$touch" v-model.trim="loginForm.email" type="email" :class="'form-control '+this.isValidEmail" id="email" aria-describedby="emailFeedback" required>
                                                <div id="emailFeedback" v-if="v$.loginForm.email.$error"  class="invalid-feedback">
                                                    {{ v$.loginForm.email.$errors[0].$message}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">{{ $t('signin.password') }}</label>
                                            <div class="input-group has-validation">
                                                <input @blur="v$.loginForm.password.$touch" v-model.trim="loginForm.password" type="password" :class="'form-control '+this.isValidPass" id="password" aria-describedby="passwordFeedback" required>
                                                <div id="passwordFeedback" v-if="v$.loginForm.password.$error" class="invalid-feedback">
                                                    {{ v$.loginForm.password.$errors[0].$message }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-text"><a href="">{{ $t('signin.signupA') }}</a> {{ $t('signin.signupStr') }}</div>

                                            <div class="form-text">{{ $t('signin.forgotPassStr') }} <router-link :to="{name:'account.forgot'}">{{ $t('signin.forgotPassA') }}</router-link></div>
                                        </div>

                                        <button @click.prevent="signIn" type="submit" class="btn btn-primary">{{ $t('signin.title') }}</button>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

    </section>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, email, minLength } from '@vuelidate/validators'
import axios from "axios";
import {useToast} from "vue-toastification";

export default {
    name: "SignIn",

    setup () {
        return {
            v$: useVuelidate(),
            t$: useToast(),
        }
    },

    data(){
        return{
            loginForm:{
                email:'',
                password:'',
            }

        }
    },

    validations(){
        return {
            loginForm:{
                email: {
                    required, email, $lazy: true
                },
                password: {
                    required, minLength:minLength(8), $lazy: true
                },
            }

        }
    },

    methods:{
        async signIn(){
            this.v$.$validate()
            const data = new FormData();

            for (let [key, value] of Object.entries(this.loginForm)) {
                data.append(key, value);
            }
            // for(let [name, value] of data) {
            //     console.log(`${name} = ${value}`);
            // }
            if(!this.v$.$error){
                await axios.post('/api/auth/login', data )
                    .then(res => {
                        console.log(res)
                        localStorage.setItem('X-XSRF-TOKEN', res.data.token);
                        localStorage.setItem('user_info', JSON.stringify(res.data.userInfo));
                        this.t$.success(res.data.message);
                        this.$router.push({name:'chat.main'});
                    })
                    .catch(error => {
                        this.t$.error(error.response.data.message)
                        console.log('error:',error);
                    })
            }else{
                console.log('Is invalid')
            }

        },
    },

    computed:{
        isValidPass(){
            return this.v$.loginForm.password.$error ? 'is-invalid':'';
        },

        isValidEmail(){
            return this.v$.loginForm.email.$error ? 'is-invalid':'';
        },
    }
}
</script>

<style scoped>

</style>
