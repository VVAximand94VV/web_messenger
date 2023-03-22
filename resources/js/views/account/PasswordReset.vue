<template>
    <section class="content h-100">

        <div class="row h-100 py-5">

            <div class="col-md-12 my-auto">

                    <div class="card mx-auto" id="resetPassForm" style="border-radius: 15px; max-width: 600px">

                        <div class="card-body">


                            <div class="row mt-3">

                                <div class="col-12 mb-4 mb-md-0">

                                    <h2 class="text-center">{{ $t('resetPassword.title') }}</h2>

                                    <form class="reset-pass-form">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ $t('resetPassword.email') }}</label>
                                            <div class="input-group has-validation">
                                                <input @blur="v$.resetPassForm.email.$touch" v-model.trim="resetPassForm.email" type="email" :class="'form-control '+this.isValidEmail" id="email" aria-describedby="emailFeedback" required>
                                                <div id="emailFeedback" v-if="v$.resetPassForm.email.$error"  class="invalid-feedback">
                                                    {{ v$.resetPassForm.email.$errors[0].$message}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="token" class="form-label">{{ $t('resetPassword.code') }}</label>
                                            <div class="input-group has-validation">
                                                <input @blur="v$.resetPassForm.token.$touch" v-model.trim="resetPassForm.token" type="text" :class="'form-control '+this.isValidToken" id="token" aria-describedby="tokenFeedback" required>
                                                <div id="tokenFeedback" v-if="v$.resetPassForm.token.$error"  class="invalid-feedback">
                                                    {{ v$.resetPassForm.token.$errors[0].$message}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="password" class="form-label">{{ $t('resetPassword.password') }}</label>
                                                <div class="input-group has-validation">
                                                    <input @blur="v$.resetPassForm.password.$touch" v-model.trim="resetPassForm.password" type="password" :class="'form-control '+this.isValidPass" id="password" aria-describedby="passwordFeedback" required>
                                                    <div id="passwordFeedback" v-if="v$.resetPassForm.password.$error" class="invalid-feedback">
                                                        {{ v$.resetPassForm.password.$errors[0].$message }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="confirmPass" class="form-label">{{ $t('resetPassword.confirmPassword') }}</label>
                                                <div class="input-group has-validation">
                                                    <input @blur="v$.resetPassForm.password_confirmation.$touch" v-model.trim="resetPassForm.password_confirmation" type="password" :class="'form-control '+this.isValidConfirmPass" id="confirmPass" aria-describedby="confirmPassFeedback" required>
                                                    <div v-if="v$.resetPassForm.password_confirmation.$error" id="confirmPassFeedback" class="invalid-feedback">
                                                        {{ v$.resetPassForm.password_confirmation.$errors[0].$message }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button @click.prevent="resetPassword" type="submit" class="btn btn-primary">{{ $t('resetPassword.title') }}</button>
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
import {required, email, minLength, maxLength, sameAs} from '@vuelidate/validators'
import axios from "axios";
import {useToast} from "vue-toastification";

export default {
    name: "PasswordReset",

    setup(){
        return {
            v$: useVuelidate(),
            t$: useToast(),
        }
    },

    data(){
        return{
            resetPassForm:{
                email:null,
                password:null,
                token:null,
            }
        }
    },

    validations(){
        return{
            resetPassForm:{
                email: { required, minLength: minLength(6), email, $lazy: true },
                token: { required, minLength: minLength(6), maxLength: maxLength(7), $lazy: true },
                password: { required, minLength: minLength(8), $lazy: true},
                password_confirmation: { required, minLength: minLength(8), sameAs: sameAs(this.resetPassForm.password), $lazy: true},
            }
        }
    },

    methods:{
        resetPassword(){
            this.v$.$validate();
            const data = new FormData();

            for(let [key, value] of Object.entries(this.resetPassForm)){
                data.append(key, value);
            }

            axios.post('/api/auth/reset-password', data)
            .then(res => {
                console.log(res);
                this.t$.success(res.data.message);
                this.$router.push({name:'account.signin'})
            })
            .catch(error => {
                this.t$.error(error.response.data.message);
                console.log('error:', error);
            })
        }
    },

    computed:{
        isValidPass(){
            return this.v$.resetPassForm.password.$error ? 'is-invalid':'';
        },

        isValidEmail(){
            return this.v$.resetPassForm.email.$error ? 'is-invalid':'';
        },

        isValidConfirmPass(){
            return this.v$.resetPassForm.password_confirmation.$error ? 'is-invalid':'';
        },

        isValidToken(){
            return this.v$.resetPassForm.token.$error ? 'is-invalid':'';
        }
    },
}
</script>

<style scoped>

</style>
