<template>
    <section>
        <DropdownSettingsMenuMain v-if="selectedMenu === 'main'" @select-menu="showSelectedMenu" />
        <DropdownSettingsEditProfile v-else-if="selectedMenu === 'edit-profile'" @select-menu="showSelectedMenu" />
        <DropdownSettingsChatPreference v-else-if="selectedMenu === 'chat-preference'" @select-menu="showSelectedMenu" />
        <DropdownSettingsLanguagePreference v-else-if="selectedMenu === 'lang-preference'" @select-menu="showSelectedMenu" />
    </section>
</template>

<script>
import DropdownSettingsEditProfile from "./DropdownSettingsEditProfile.vue";
import DropdownSettingsMenuMain from "./DropdownSettingsMenuMain.vue";
import DropdownSettingsChatPreference from "./DropdownSettingsChatPreference.vue";
import DropdownSettingsLanguagePreference from "./DropdownSettingsLanguagePreference.vue";
export default {
    name: "DropdownSettings",
    components: {
        DropdownSettingsLanguagePreference,
        DropdownSettingsChatPreference,
        DropdownSettingsMenuMain,
        DropdownSettingsEditProfile
    },

    data(){
        return{
            selectedMenu:'main',
        }
    },

    methods:{
        showSelectedMenu(selectedMenu){
            console.log('Selected menu: '+this.selectedMenu)
            this.selectedMenu = selectedMenu
        }
    }
}
</script>

<style scoped>

</style>
