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

export default {
    name: "App",
    components: { UserSidebar, SettingModal, ContactsModal },

    mounted(){
        this.$store.dispatch('changeTheme', localStorage.getItem('theme'))
    },

}
</script>

<style scoped>

</style>
