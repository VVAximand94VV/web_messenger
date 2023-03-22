<template>
    <ul class="list-unstyled">
        <DropdownSettingsListItem v-for="item in settingsMenu" :label="item.label" :icon="item.icon" @click="$emit('select-menu', item.link)" />
    </ul>
</template>

<script>
import DropdownSettingsListItem from "./DropdownSettingsListItem.vue";

export default {
    name: "DropdownSettingsMenuMain",
    components: {DropdownSettingsListItem},

    data(){
        return{
            selectedMenu:'',

            settingsMenu:[
                {
                    label: this.$t('dropdownMenu.editProfile'),
                    icon:'fas fa-user',
                    link:'edit-profile'
                },
                {
                    label: this.$t('dropdownMenu.chatPreference'),
                    icon:'fas fa-comment',
                    link:'chat-preference',
                },
                {
                    label: this.$t('dropdownMenu.language'),
                    icon:'fas fa-globe',
                    link:'lang-preference',
                },
            ]
        }
    },
}
</script>

<style scoped>

</style>
