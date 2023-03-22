<template>
    <section class="content h-100">

        <div class="row h-100 py-5">

            <div class="col-md-12 my-auto">

                    <div class="card mx-auto" id="forgotPassForm" style="border-radius: 15px; max-width: 600px">

                        <div class="card-body">


                            <div class="row mt-3">

                                <div class="col-12 mb-4 mb-md-0">

                                    <h2 class="text-center">{{ $t('forgotPassword.title') }}</h2>

                                    <div class="mb-3">
                                        <p>{{ $t('forgotPassword.text') }}</p>
                                    </div>

                                    <form class="forgot-pass-form">

                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ $t('forgotPassword.email') }}</label>
                                            <div class="input-group has-validation">
                                                <input @blur="v$.email.$touch" v-model.trim="email" type="email" :class="'form-control '+this.isValidEmail" id="email" aria-describedby="emailFeedback" required>
                                                <div id="emailFeedback" v-if="v$.email.$error"  class="invalid-feedback">
                                                    {{ v$.email.$errors[0].$message}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-text"><a href="">{{ $t('signup.title') }}</a> {{ $t('forgotPassword.signupStr') }}</div>
                                        </div>

                                        <button @click.prevent="forgotPassword" type="submit" class="btn btn-primary">{{ $t('forgotPassword.title') }}</button>
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
    name: "ForgotPassword",

    setup () {
        //const toast = useToast();
        return {
            v$: useVuelidate(),
            t$: useToast(),
        }
    },

    data(){
        return{
            email:null,
        }
    },

    validations(){
        return{
            email : {required, email, minLength: minLength(6)}
        }
    },

    computed:{
        isValidEmail(){
            return this.v$.email.$error ? 'is-invalid':'';
        }
    },

    methods:{
         async forgotPassword(){
            this.v$.$validate()

            if(!this.v$.$error){
                await axios.post('/api/auth/forgot-password', {
                    email: this.email
                })
                    .then(res => {
                        this.t$.success(res.data.message);
                        //console.log('res:', res.data.message);
                        this.$router.push({name:'account.signin'})
                    })
                    .catch(error => {
                        this.t$.error(error.response.data.message);
                        //console.log('error:', error);
                    })
            }else{
                console.log('Errors!')
            }
        },
    }

}
</script>

<style scoped>

</style>
