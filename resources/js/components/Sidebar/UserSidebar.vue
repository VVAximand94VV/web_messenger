<template>
    <div class="sidebar">

        <span class="close-btn" role="button" @click.prevent="this.$store.dispatch('changeSidebar')"><i class="fas fa-times"></i></span>

        <div class= "sidebar-block d-flex justify-content-between mt-3">
            <img :src="userAvatar" alt="avatar" class="ml-3 d-flex me-3 rounded-circle" width="65">

            <span class="logout-btn d-flex align-self-center" role="button" @click.prevent="this.$store.dispatch('logout')" :title="$t('sidebar.logout')"><i class="fas fa-sign-out-alt"></i></span>

        </div>

        <ul class="list-unstyled sidebar-menu mt-5">
            <li><span class="" role="button" data-bs-toggle="modal" data-bs-target="#contacts-modal"><i class="fas fa-users sidebar-icon"></i> {{ $t('sidebar.contacts') }}</span></li>
            <li><span class="" role="button" data-bs-toggle="modal" data-bs-target="#setting-modal"><i class="fas fa-cog sidebar-icon"></i> {{ $t('sidebar.settings') }}</span></li>
            <li>
                <div class="d-flex flex-row justify-content-between">
                    <i class="fas fa-moon sidebar-icon"></i>
                    <span> {{ $t('sidebar.nightMode') }}</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" v-model="isDarkMode" @click="this.$store.dispatch('changeTheme',!isDarkMode)" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    </div>
                </div>
            </li>
        </ul>

    </div>
</template>

<script>

export default{
    name:'UserSidebar',

    data(){
        return{
            isDarkMode: JSON.parse(localStorage.getItem('theme'))??false,
            userAvatar: JSON.parse(localStorage.getItem('user_info')).avatar,
        }
    },


}

</script>

<style scoped>

</style>
