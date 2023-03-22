<template>
    <DropdownSettingsHeader @back="$emit('select-menu', 'main')" :title="$t('dropdownMenu.chatPreference')" />
    <div class="mt-2">
        <span>Chat preference view</span>
    </div>
</template>

<script>
import DropdownSettingsHeader from "./DropdownSettingsHeader.vue";
export default {
    name: "DropdownSettingsChatPreference",
    components: {DropdownSettingsHeader}
}
</script>

<style scoped>

</style>
