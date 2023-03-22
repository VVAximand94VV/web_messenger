<template>
    <DropdownSettingsHeader @back="$emit('select-menu', 'main')" :title="$t('dropdownMenu.editProfile')" />
    <div class="mt-3 p-1">
        <EditProfileInput v-for="item in editInputs" :icon="item.icon" :label="item.label" :id="item.id" :type="item.type" :value="item.value" />
    </div>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, email, minLength } from '@vuelidate/validators'
import DropdownSettingsHeader from "./DropdownSettingsHeader.vue";
import axios from "axios";
import EditProfileInput from "./EditProfileInput.vue";
export default {
    name: "DropdownSettingsEditProfile",
    components: {EditProfileInput, DropdownSettingsHeader},

    setup () {
        return { v$: useVuelidate() }
    },

    data(){
        return{

            editInputs:[
                {
                    icon:'fa-file-signature',
                    label: this.$t('dropdownMenu.profile.login'),
                    id:'login',
                    type:'text',
                    value: JSON.parse(localStorage.getItem('user_info')).login,
                },
                {
                    icon:'fa-file-signature',
                    label: this.$t('dropdownMenu.profile.firstName'),
                    id:'firstName',
                    type:'text',
                    value: JSON.parse(localStorage.getItem('user_info')).firstName,
                },
                {
                
                    icon:'fa-file-signature',
                    label: this.$t('dropdownMenu.profile.lastName'),
                    id:'lastName',
                    type:'text',
                    value: JSON.parse(localStorage.getItem('user_info')).lastName,
                },
                {
                    icon:'fa-envelope-square',
                    label: this.$t('dropdownMenu.profile.email'),
                    id:'email',
                    type:'email',
                    value: JSON.parse(localStorage.getItem('user_info')).email,
                },
                {
                    icon:'fa-phone-square-alt',
                    label: this.$t('dropdownMenu.profile.phone'),
                    id:'phone',
                    type:'tel',
                    value: JSON.parse(localStorage.getItem('user_info')).phone,
                },
            ],
        }
    },

    mounted() {
        console.log(this.user)
    },

    validations(){
        return{
            // login: { required },
            // firstName: { required },
            // lastName: { required },
            // email: { required, email },
            // phone: { required },
        }
    },

    methods:{

    },

    computed:{
        isValidLogin(){
            return this.v$.login.$error ? 'is-invalid':'';
        },
    }
}
</script>

<style scoped>
input{
    padding: 0;
}

.icon{
    font-size: 1.2em;
    margin-right: 10px;
}
</style>
