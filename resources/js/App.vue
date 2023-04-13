<template>
        <!-- Sidebar -->
        <UserSidebar />
        <!-- ./ Sidebar -->

        <section class="main">
            <router-view></router-view>
        </section>

        <!-- User settings modal -->
        <SettingModal id="setting-modal"/>

        <ContactsModal id="contacts-modal"/>


</template>

<script>
import UserSidebar from './components/Sidebar/UserSidebar.vue';
import SettingModal from './components/SettingModal.vue';
import ContactsModal from './components/contactsModal/ContactsModal.vue';
import {nextTick} from "vue";

export default {
    name: "App",
    components: { UserSidebar, SettingModal, ContactsModal },

    created(){
        //this.$store.dispatch('changeColorStyle', localStorage.getItem('color-them'))
        this.$store.dispatch('changeTheme', localStorage.getItem('theme'))
    },


    mounted(){
        // this.$nextTick(function () {
        //     console.log('sssssssssssssssssssssssss')
        //     this.$store.dispatch('changeColorStyle', localStorage.getItem('color-them'))
        // })

    },

}
</script>

<style scoped>

</style>
