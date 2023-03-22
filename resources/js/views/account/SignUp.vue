<template>
<!--    <div class="row">-->
<!--        <h1 class="text-center mt-1 my-auto p-2">Live Chat</h1>-->
<!--    </div>-->

    <section class="content h-100">

        <div class="row h-100 py-5">

            <div class="col-md-12 my-auto">

                    <div class="card mx-auto" id="registrationForm" style="border-radius: 15px; max-width: 600px">

                        <div class="card-body">


                            <div class="row mt-3">

                                <div class="col-12 mb-4 mb-md-0">

                                    <h2 class="text-center mb-3">{{ $t('signup.title') }}</h2>

                                    <!-- Server error messages -->

                                    <!-- Server error messages end -->

                                    <form class="registration-form">

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="login" class="form-label">{{ $t('signup.login') }}</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend3">@</span>
                                                    <input @blur="v$.registerForm.login.$touch" v-model.trim="registerForm.login" type="text" :class="'form-control '+this.isValidLogin" id="login" aria-describedby="loginFeedback" required>
                                                    <div v-if="v$.registerForm.login.$error" id="loginFeedback" class="invalid-feedback">
                                                        {{ v$.registerForm.login.$errors[0].$message }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="firstName" class="form-label">{{ $t('signup.firstName') }}</label>
                                                <div class="input-group has-validation">
                                                    <input @blur="v$.registerForm.firstName.$touch" v-model.trim="registerForm.firstName" type="text" :class="'form-control '+this.isValidFirstName" id="firstName" aria-describedby="firstNameFeedback" required>
                                                    <div v-if="v$.registerForm.firstName.$error" id="firstNameFeedback" class="invalid-feedback">
                                                        {{ v$.registerForm.firstName.$errors[0].$message }}
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <label for="lastName" class="form-label">{{ $t('signup.lastName') }}</label>
                                                <div class="input-group has-validation">
                                                    <input @blur="v$.registerForm.lastName.$touch" v-model.trim="registerForm.lastName" type="text" :class="'form-control '+this.isValidLastName" id="lastName" aria-describedby="lastNameFeedback" required>
                                                    <div v-if="v$.registerForm.lastName.$error" id="lastNameFeedback" class="invalid-feedback">
                                                        {{ v$.registerForm.lastName.$errors[0].$message }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ $t('signup.email') }}</label>
                                            <div class="input-group has-validation">
                                                <input @blur="v$.registerForm.email.$touch" v-model.trim="registerForm.email" type="email" id="email" :class="'form-control '+this.isValidEmail" aria-describedby="emailFeedback" required>
                                                <div v-if="v$.registerForm.email.$error" id="emailFeedback" class="invalid-feedback">
                                                    {{ v$.registerForm.email.$errors[0].$message }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="phone" class="form-label">{{ $t('signup.phone') }}</label>
                                            <div class="input-group has-validation">
                                                <input @blur="v$.registerForm.phone.$touch" v-model.trim="registerForm.phone" pattern="[7-9]{1}[0-9]{9}" type="tel" id="phone" :class="'form-control '+this.isValidPhone" aria-describedby="phoneFeedback" required>
                                                <div v-if="v$.registerForm.phone.$error" id="phoneFeedback" class="invalid-feedback">
                                                    {{ v$.registerForm.phone.$errors[0].$message }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="password" class="form-label">{{ $t('signup.password') }}</label>
                                                <div class="input-group has-validation">
                                                    <input @blur="v$.registerForm.password.$touch" v-model.trim="registerForm.password" type="password" :class="'form-control '+this.isValidPass" id="password" aria-describedby="passwordFeedback" required>
                                                    <div v-if="v$.registerForm.password.$error" id="passwordFeedback" class="invalid-feedback">
                                                        {{ v$.registerForm.password.$errors[0].$message }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="confirmPass" class="form-label">{{ $t('signup.confirmPassword') }}</label>
                                                <div class="input-group has-validation">
                                                    <input @blur="v$.registerForm.password_confirmation.$touch" v-model.trim="registerForm.password_confirmation" type="password" :class="'form-control '+this.isValidConfirmPass" id="confirmPass" aria-describedby="confirmPassFeedback" required>
                                                    <div v-if="v$.registerForm.password_confirmation.$error" id="confirmPassFeedback" class="invalid-feedback">
                                                        {{ v$.registerForm.password_confirmation.$errors[0].$message }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-text"><a href="">{{ $t('signup.signinA') }}</a> {{ $t('signup.signinStr') }}</div>
                                        </div>

                                        <button @click.prevent="signUp" type="submit" class="btn btn-primary">{{ $t('signup.title') }}</button>
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
import { required, email, minLength, maxLength, sameAs, } from '@vuelidate/validators'
import axios from "axios";
import { useToast } from "vue-toastification";

export default {
    name: "SignUp",

    setup () {
        const toast = useToast();
        return {
            v$: useVuelidate(),
            t$: useToast(),
        }
    },

    data(){
        return{
            registerForm:{
                login:'',
                firstName:'',
                lastName:'',
                email:'',
                phone:'',
                password:'',
                password_confirmation:''
            },
        }
    },

    validations(){
        return{
            registerForm:{
                login: { required, minLength: minLength(6), $lazy: true},
                firstName: { required, minLength: minLength(3), $lazy: true },
                lastName: { required, minLength: minLength(3), $lazy: true },
                email: { required, minLength: minLength(6), email, $lazy: true },
                phone: { required, minLength: minLength(9), maxLength: maxLength(13), $lazy: true },
                password: { required, minLength: minLength(8), $lazy: true},
                password_confirmation: { required, minLength: minLength(8), sameAs: sameAs(this.registerForm.password), $lazy: true},
            },
        }
    },

    methods:{
        async signUp(){
            this.v$.$validate()
            const data = new FormData();

            for (let [key, value] of Object.entries(this.registerForm)) {
                data.append(key, value);
            }
            if(!this.v$.$error){
                await axios.post('/api/auth/register', data)
                    .then(res => {
                        console.log('response', res);
                        // toast
                        localStorage.setItem('X-XSRF-TOKEN', res.data.token);
                        localStorage.setItem('user_info', JSON.stringify(res.data.userInfo));
                        this.t$.success(res.data.message);
                        this.$router.push({name:'chat.main'});
                    })
                    .catch(error => {
                        this.t$.error(error.response.data.message ?? 'Error' );
                        console.log('error: ', error);
                    })
            }else{
                console.log('Is invalid!')
            }
        },
    },

    computed:{
        isValidEmail(){
            return this.v$.registerForm.email.$error ? 'is-invalid':'';
        },

        isValidPass(){
            return this.v$.registerForm.password.$error ? 'is-invalid':'';
        },

        isValidConfirmPass(){
            return this.v$.registerForm.password_confirmation.$error ? 'is-invalid':'';
        },

        isValidLogin(){
            return this.v$.registerForm.login.$error ? 'is-invalid':'';
        },

        isValidFirstName(){
            return this.v$.registerForm.firstName.$error ? 'is-invalid':'';
        },

        isValidLastName(){
            return this.v$.registerForm.lastName.$error ? 'is-invalid':'';
        },

        isValidPhone(){
            return this.v$.registerForm.phone.$error ? 'is-invalid':'';
        },
    }
}
</script>

<style scoped>

</style>
