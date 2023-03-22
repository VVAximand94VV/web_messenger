<template>
    <section class="content h-100">

        <div class="row h-100 py-5">

            <div class="col-md-12 my-auto">

                    <div class="card mx-auto" id="email-notification" style="border-radius: 15px; max-width: 600px">

                        <div class="card-body">


                            <div class="row mt-3">

                                <div class="col-12 mb-4 mb-md-0">

                                    <h2 class="text-center">{{ $t('emailNotifyView.title') }}</h2>

                                    <div class="" v-text="notification">

                                    </div>

                                    <div>
                                        <router-link v-if="token" :to="{name:'chat.main'}">{{ $t('emailNotifyView.back') }}</router-link>
                                        <router-link v-if="!token" :to="{name:'account.signin'}">{{ $t('signin.title') }}</router-link>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

            </div>

        </div>
    </section>
</template>

<script>
export default {
    name: "Email",

    data(){
        return{
            notification:'',
            token:localStorage.getItem('X-XSRF-TOKEN'),
        }
    },

    mounted() {
        this.notifiedMessage()
    },

    methods:{
        notifiedMessage(){
            if(this.$route.params.status==='verified'){
                console.log('Email verified.');
                this.notification = 'Email verified.';
            }else{
                console.log('Error! Failed to verify email address.');
                this.notification = 'Error! Failed to verify email address.';
            }
        }
    }
}
</script>

<style scoped>

</style>
